<?php

namespace AppBundle\Manager;

use AppBundle\Entity\IpPermissionList;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Exception;

/**
 * @package AppBundle\Service
 * @property IpPermissionListManager $repository
 */
class IpPermissionListManager extends AbstractManager
{

    /**
     * @return IpPermissionList
     * @throws NonUniqueResultException
     */
    public function findByIp($ip, int $status=null)
    {
        return $this->repository->findByIp($ip, $status);
    }


    /**
     * @param IpPermissionList $ipPermissionList
     * @return bool
     */
    public function create(IpPermissionList $ipPermissionList){
        try {
            $this->em->persist($ipPermissionList);
            $this->em->flush();
        } catch (ORMException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * @param IpPermissionList $ipPermissionList
     * @return bool
     */
    public function update(IpPermissionList $ipPermissionList){
        try {
            $this->em->persist($ipPermissionList);
            $this->em->flush();
        } catch (ORMException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * @param IpPermissionList $ipPermissionList
     * @return bool
     */
    public function delete(IpPermissionList $ipPermissionList){
        try {
            $this->em->remove($ipPermissionList);
            $this->em->flush();
        } catch (ORMException $e) {
            return $e->getMessage();
        }

    }


    /**
     * @return string
     */
    public function getEntityName()
    {
        return 'AppBundle:IpPermissionList';
    }
}
