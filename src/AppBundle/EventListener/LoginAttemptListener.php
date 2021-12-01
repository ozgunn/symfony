<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\IpPermissionList;
use AppBundle\Entity\LoginAttempt;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LoginAttemptListener implements EventSubscriberInterface
{

    private $container;

    public function __construct(ContainerInterface $container)
    {

        $this->container = $container;
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ('login' !== $event->getRequest()->attributes->get('_route')) {
            return;
        }

        $ip = $event->getRequest()->getClientIp();
        $user = $event->getRequest()->get("email");
        $agent = substr($event->getRequest()->headers->get('User-agent'), 0,255);
        $maxAttempt = $this->container->getParameter('login_attempts_max');
        $interval = $this->container->getParameter('login_attempts_minutes');
        $ipLimit = $this->container->getParameter('login_attempts_ip_limit');
        $ipTimeout = $this->container->getParameter('login_attempts_ip_timeout');
        $now = new \DateTime();

        $manager = $this->container->get('app.login_attempt_manager');
        $ipListManager = $this->container->get('app.ip_permission_list_manager');

        // Blacklist kontrolü
        // FİKİR: Expire alanı eklenerek süreli block eklenebilir ve belli sayının üzerindeki login denemelerinde otomatik block konulabilir.
        $ipBlocked = $ipListManager->findByIp($ip, IpPermissionList::DENY);
        if ($ipBlocked) {
            throw new AccessDeniedException("Your IP address is blocked.");
        }

        // Aynı IPden açılan oturum kontrolü
        $ipAllowed = $ipListManager->findByIp($ip, IpPermissionList::ALLOW);
        $userCount = $manager->findUsersByIp($ip, $ipTimeout);

        if ($userCount > $ipLimit && !$ipAllowed) {
            throw new AccessDeniedException("Max allowed session limit exceeded.");
        }

        // Aynı IPden yapılan login denemesi kontrolü
        $checkIp = $manager->findByIp($ip, $interval);

        /**
         * @var LoginAttempt $checkIp
         */
        if ($checkIp) {
            if ($checkIp->getCount() >= $maxAttempt) {
                throw new AccessDeniedException("Too many requests.");
            }

            $checkIp->setCount($checkIp->getCount() + 1);

            $manager->update($checkIp);
        } else {
            $loginAttempt = new LoginAttempt();
            $loginAttempt->setIp($ip);
            $loginAttempt->setUser($user);
            $loginAttempt->setCreatedAt($now);
            $loginAttempt->setUserAgent($agent);
            $loginAttempt->setCount(1);

            $manager->create($loginAttempt);
        }

    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 9]
        ];
    }
}
