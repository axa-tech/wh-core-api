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
     * @ORM\Column(name="ip", type="string", nullable=true)
     */
    private $ip;

    /**
     * @ORM\ManyToOne(targetEntity="Platform", inversedBy="virtualMachines")
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
     * @ORM\ManyToMany(targetEntity="Docker", inversedBy="vms")
     * @ORM\JoinTable(name="vms_dockers")
     **/
    private $dockers;


    /**
     * @var Vm
     *
     * @ORM\OneToOne(targetEntity="VmQueue", mappedBy="vm", cascade={"persist"})
     */
    private $queue;


    public function __construct()
    {
        $this->metadata = new ArrayCollection();
        $this->dockers = new ArrayCollection();
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
     * Set ip
     *
     * @param $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
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
     * Add a docker
     *
     * @param Docker $docker
     * @return Vm
     */
    public function addDocker(Docker $docker)
    {
        $docker->addVm($this);
        $this->dockers->add($docker);

        return $this;
    }

    /**
     * Returns all vm's dockers
     *
     * @return ArrayCollection
     */
    public function getDockers()
    {
        return $this->dockers;
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
}
