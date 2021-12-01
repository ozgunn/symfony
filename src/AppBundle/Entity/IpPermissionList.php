<?php

namespace AppBundle\Entity;

use AppBundle\Helper\Traits\EntityTimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="ip_permission_list", indexes={
 *     @ORM\Index(name="IDX_OBJECT_IP", columns={"ip"}),
 *     @ORM\Index(name="IDX_PERMISSION_IP", columns={"allowed"})
 * })
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IpPermissionListRepository")
 */
class IpPermissionList
{
    use EntityTimestampTrait;
    use SoftDeleteableEntity;

    const ALLOW = 1;
    const DENY = 0;

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"ip_permission_list"})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="ip", type="string")
     * @Serializer\Groups({"ip_permission_list"})
     */
    private $ip;

    /**
     * @var int
     * @ORM\Column(name="allowed", type="smallint")
     * @Serializer\Groups({"ip_permission_list"})
     */
    private $allowed;

    

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
     * Set ip.
     *
     * @param string $ip
     *
     * @return IpPermissionList
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
     * Set allowed.
     *
     * @param int $allowed
     *
     * @return IpPermissionList
     */
    public function setAllowed($allowed)
    {
        $this->allowed = $allowed;

        return $this;
    }

    /**
     * Get allowed.
     *
     * @return int
     */
    public function getAllowed()
    {
        return $this->allowed;
    }
}
