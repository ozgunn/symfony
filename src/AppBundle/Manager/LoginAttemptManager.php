<?php

namespace AppBundle\Manager;

use AppBundle\Entity\LoginAttempt;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Exception;

/**
 * @package AppBundle\Service
 * @property LoginAttemptManager $repository
 */
class LoginAttemptManager extends AbstractManager
{

    /**
     * @return LoginAttempt
     * @throws NonUniqueResultException
     */
    public function findByIp($ip, int $interval)
    {
        return $this->repository->findByIp($ip, $interval);
    }

    /**
     * @return LoginAttempt
     * @throws NonUniqueResultException
     */
    public function findUsersByIp($ip, int $interval)
    {
        return $this->repository->findUsersByIp($ip, $interval);
    }

    /**
     * @param LoginAttempt $loginAttempt
     * @return bool
     */
    public function create(LoginAttempt $loginAttempt){
        try {
            $this->em->persist($loginAttempt);
            $this->em->flush();
        } catch (ORMException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * @param LoginAttempt $loginAttempt
     * @return bool
     */
    public function update(LoginAttempt $loginAttempt){
        try {
            $this->em->persist($loginAttempt);
            $this->em->flush();
        } catch (ORMException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * @param LoginAttempt $loginAttempt
     * @return bool
     */
    public function delete(LoginAttempt $loginAttempt){
        try {
            $this->em->remove($loginAttempt);
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
        return 'AppBundle:LoginAttempt';
    }
}
