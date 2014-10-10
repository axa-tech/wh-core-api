<?php

namespace Axa\Bundle\WhapiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vm
 *
 * @ORM\Table(name="vm")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\VmRepository")
 */
class Vm
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
     * @ORM\Column(name="remote_id", type="string", nullable=true)
     */
    private $remoteId;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", nullable=true)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="instance_name", type="string", nullable=true)
     */
    private $instanceName;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     *
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Platform", inversedBy="virtualMachines", cascade={"all"})
     */
    private $platform;

    /**
     * @ORM\OneToMany(targetEntity="VmMetadata", mappedBy="vm")
     */
    private $metadata;

    /**
     * @ORM\ManyToOne(targetEntity="Docker", inversedBy="vms")
     * @ORM\JoinColumn(name="offer_id", referencedColumnName="id", nullable=false)
     */

    /**
     * @ORM\OneToMany(targetEntity="Container", mappedBy="vm", cascade={"persist"})
     */
    private $containers;

    /**
     * @var Vm
     *
     * @ORM\OneToOne(targetEntity="VmQueue", mappedBy="vm", cascade={"persist"})
     */
    private $queue;


    public function __construct()
    {
        $this->metadata = new ArrayCollection();
        $this->containers = new ArrayCollection();
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
     * Set remoteId
     *
     * @param $remoteId
     * @return $this
     */
    public function setRemoteId($remoteId)
    {
        $this->remoteId = $remoteId;

        return $this;
    }

    /**
     * Get remoteId
     *
     * @return string
     */
    public function getRemoteId()
    {
        return $this->remoteId;
    }

    /**
     * Set ipAddress
     *
     * @param $ipAddress
     * @return $this
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set instanceName
     *
     * @param $instanceName
     * @return $this
     */
    public function setInstanceName($instanceName)
    {
        $this->instanceName = $instanceName;

        return $this;
    }

    /**
     * Get instanceName
     *
     * @return string
     */
    public function getInstanceName()
    {
        return $this->instanceName;
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
            throw new \InvalidArgumentException(sprintf("The status: %s is invalid! Use DONE, IN_PROGRESS or ERROR ", $status));
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
     * Set platform
     *
     * @param Platform $platform
     * @return $this
     */
    public function setPlatform(Platform $platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @return Platform
     */
    public function getPlatform()
    {
        return $this->platform;
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
     * Set queue
     *
     * @param VmQueue $queue
     * @return Vm
     */
    public function setQueue(VmQueue $queue)
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * Get queue
     *
     * @return VmQueue
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * Returns the Vm's metadata
     *
     * @return array
     */
    public function getMetadataToArray()
    {
        $metadata = $this->getMetadata()->toArray();
        $response = array();
        foreach($metadata as $m){

            $response[] = $m->toArray();

        }

        return $response;
    }

    /**
     * Get containers
     *
     * @return ArrayCollection
     */
    public function getContainers()
    {
        return $this->containers;
    }

    /**
     * Add a new container to the vm
     *
     * @param Container $container
     * @return $this
     */
    public function addContainer(Container $container)
    {
        $container->setVm($this);
        $this->containers->add($container);

        return $this;
    }
}
