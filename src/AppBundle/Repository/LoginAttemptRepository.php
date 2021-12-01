<?php

namespace AppBundle\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;


class LoginAttemptRepository extends EntityRepository
{

    /**
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findByIp($ip, int $interval)
    {
        $now = new DateTime();
        $expire = $now->modify("-{$interval} minutes");

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('login')
            ->from('AppBundle:LoginAttempt', 'login')
            ->andWhere('login.ip=:ip')
            ->setParameter('ip',$ip)
            ->andWhere('login.createdAt > :expire')
            ->setParameter('expire',$expire)
        ;
        return $query->getQuery()->getOneOrNullResult();

    }

    /**
     * @param $ip
     * @param int $interval
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findUsersByIp($ip, int $interval)
    {
        $now = new DateTime();
        $expire = $now->modify("-{$interval} minutes");

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('COUNT(DISTINCT login.user)')
            ->from('AppBundle:LoginAttempt', 'login')
            ->andWhere('login.ip=:ip')
            ->setParameter('ip',$ip)
            ->andWhere('login.createdAt > :expire')
            ->setParameter('expire',$expire)
        ;
        return $query->getQuery()->getSingleScalarResult();

    }

}
