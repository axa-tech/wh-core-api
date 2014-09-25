<?php

namespace Axa\Bundle\WhapiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Platform
 *
 * @ORM\Table(name="platform")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\PlatformRepository")
 */
class Platform
{
    CONST STATUS_IN_PROGRESS = 'IN_PROGRESS';
    CONST STATUS_DONE = 'DONE';
    CONST STATUS_ERROR = 'ERROR';

    public static $statuses = array(

        self::STATUS_IN_PROGRESS,
        self::STATUS_DONE,
        self::STATUS_ERROR
    );

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     *
     */
    private $status;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="platforms")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Offer", inversedBy="platforms")
     * @ORM\JoinColumn(name="offer_id", referencedColumnName="id", nullable=false)
     */
    private $offer;


    /**
     * @ORM\OneToMany(targetEntity="Vm", mappedBy="platform", cascade={"persist"})
     */
    private $virtualMachines;

    /**
     * @ORM\OneToMany(targetEntity="PlatformMetadata", mappedBy="platform", cascade={"persist"})
     */
    private $metadata;


    public function __construct()
    {
        $this->virtualMachines = new ArrayCollection();
        $this->metadata = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param $status
     * @return $this
     * @throws
     */
    public function setStatus($status)
    {
        if(! in_array($status, self::$statuses)) {
            throw \InvalidArgumentException(sprintf("The status %s is invalid", $status));
        }
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Platform
     */
    public function setUser( User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get virtualMachines
     *
     * @return ArrayCollection
     */
    public function getVirtualMachines()
    {
        return $this->virtualMachines;
    }

    /**
     * Set offer
     *
     * @param Offer $offer
     * @return Platform
     */
    public function setOffer(Offer $offer)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return Offer
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Get metadata
     *
     * @return ArrayCollection
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Returns the Platform's metadata
     *
     * @return array
     */
    public function getMetadataToArray()
    {
        return $metadata = $this->getMetadata()->getValues();
    }
}
