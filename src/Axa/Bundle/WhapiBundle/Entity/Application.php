<?php

namespace Axa\Bundle\WhapiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Container
 *
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\ApplicationRepository")
 * @ExclusionPolicy("all")
 */
class Application
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
     * @Expose
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Expose
     * @ORM\Column(name="url", type="string", length=255, unique=true)
     */
    private $url;

    /**
     * @var string
     * @Expose
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="topology", type="integer", length=10)
     */
    private $topology;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;


    /**
     * @ORM\ManyToOne(targetEntity="Stack", inversedBy="applications")
     * @ORM\JoinColumn(name="stack_id", referencedColumnName="id", nullable=false)
     * @Expose
     */
    private $stack;

    /**
     * @ORM\OneToMany(targetEntity="Container", mappedBy="application")
     *
     */
    private $containers;

    /**
     * @ORM\ManyToOne(targetEntity="Platform", inversedBy="applications")
     */
    private $platform;


    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set url
     *
     * @param string $url
     * @return Application
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
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
     * Set topology
     *
     * @param string $topology
     * @return Application
     */
    public function setTopology($topology)
    {
        $this->topology = $topology;

        return $this;
    }

    /**
     * Get topology
     *
     * @return string 
     */
    public function getTopology()
    {
        return $this->topology;
    }

    /**
     * Set name
     *
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set stack
     *
     * @param Stack $stack
     * @return $this
     */
    public function setStack(Stack $stack)
    {
        $this->stack = $stack;

        return $this;
    }

    /**
     * @return Stack
     */
    public function getStack()
    {
        return $this->stack;
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
     * Add a new container to the application
     *
     * @param Container $container
     * @return Application
     */
    public function addContainer(Container $container)
    {
        $this->containers->add($container);
        $container->setApplication($this);

        return $this;
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
}
