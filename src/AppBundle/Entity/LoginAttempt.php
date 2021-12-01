<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="login_attempt", indexes={
 *     @ORM\Index(name="IDX_ATTEMPTED_IP", columns={"ip"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoginAttemptRepository")
 */
class LoginAttempt
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"login_attempt"})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="user", type="string", nullable=true)
     * @Serializer\Groups({"login_attempt"})
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(name="ip", type="string")
     * @Serializer\Groups({"login_attempt"})
     */
    private $ip;

    /**
     * @var int
     * @ORM\Column(name="count", type="smallint")
     * @Serializer\Groups({"login_attempt"})
     */
    private $count = 1;

    /**
     * @var string
     * @ORM\Column(name="user_agent", type="text", nullable=true)
     * @Serializer\Groups({"login_attempt"})
     */
    private $userAgent;

    /**
     * @var DateTime
     * @ORM\Column(name="created_at", type="datetime")
     * @Serializer\Groups({"login_attempt"})
     */
    private $createdAt;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user.
     *
     * @param string|null $user
     *
     * @return LoginAttempt
     */
    public function setUser($user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return string|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set ip.
     *
     * @param string $ip
     *
     * @return LoginAttempt
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set count.
     *
     * @param int $count
     *
     * @return LoginAttempt
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set userAgent.
     *
     * @param string|null $userAgent
     *
     * @return LoginAttempt
     */
    public function setUserAgent($userAgent = null)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get userAgent.
     *
     * @return string|null
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return LoginAttempt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
