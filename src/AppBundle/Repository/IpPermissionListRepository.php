<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;


class IpPermissionListRepository extends EntityRepository
{

    /**
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findByIp($ip, int $status = null)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('ip')
            ->from('AppBundle:IpPermissionList', 'ip')
            ->where('ip.ip=:ip')
            ->setParameter('ip',$ip)
            ->orderBy('ip.id','desc')
        ;
        if ($status !== null) {
            $query->andWhere('ip.allowed =:status')
                ->setParameter('status', $status);
        }

        return $query->getQuery()->getOneOrNullResult();

    }

}
