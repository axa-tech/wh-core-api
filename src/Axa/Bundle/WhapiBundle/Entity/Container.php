<?php

namespace Axa\Bundle\WhapiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Container
 *
 * @ORM\Table(name="container")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\ContainerRepository")
 */
class Container
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
     * @var integer
     *
     * @ORM\Column(name="port", type="integer", length=10)
     */
    private $port;

    /**
     * @var integer
     *
     * @ORM\Column(name="memory_limit", type="integer", length=10)
     */
    private $memoryLimit;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="remote_id", type="string", length=255)
     */
    private $remoteId;


    /**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="containers")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id", nullable=false)
     */
    private $application;

    /**
     * @ORM\ManyToOne(targetEntity="Vm", inversedBy="containers")
     * @ORM\JoinColumn(name="vm_id", referencedColumnName="id", nullable=false)
     */
    private $vm;

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
     * Set port
     *
     * @param string $port
     * @return Container
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return string 
     */
    public function getPort()
    {
        return $this->port;
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
     * Set remoteId
     *
     * @param string $remoteId
     * @return Container
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
     * Set Application
     *
     * @param Application $application
     * @return $this
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get Application
     *
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set vm
     *
     * @param Vm $vm
     * @return $this
     */
    public function setVm(Vm $vm)
    {
        $this->vm = $vm;

        return $this;
    }

    /**
     * Get vm
     *
     * @return Vm
     */
    public function getVm()
    {
        return $this->vm;
    }
}
