<?php

namespace Axa\Bundle\WhapiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\OfferRepository")
 */
class Offer
{

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Small platform code
     */
    const SMALL_PLATFORM_CODE    = 'SP';

    /**
     * Medium platform code
     */
    const MEDIUM_PLATFORM_CODE   = 'MP';

    /**
     * Large platform code
     */
    const LARGE_PLATFORM_CODE    = 'LP';

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
     * @ORM\Column(name="code", type="string", unique=true, length=10)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="cpu", type="integer")
     */
    private $cpu;

    /**
     * @var integer
     *
     * @ORM\Column(name="memory", type="integer")
     */
    private $memory;

    /**
     * @var integer
     *
     * @ORM\Column(name="storage", type="integer")
     */
    private $storage;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_vm", type="integer")
     */
    private $nbVm;


    /**
     * @ORM\OneToMany(targetEntity="Platform", mappedBy="offer")
     */
    private $platforms;


    public function __construct()
    {
        $this->platforms = new ArrayCollection();
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
     * Set code
     *
     * @param string $code
     * @return Offer
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Offer
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
     * Set cpu
     *
     * @param $cpu
     * @return Offer
     */
    public function setCpu($cpu)
    {
        $this->cpu = $cpu;

        return $this;
    }

    /**
     * Get cpu
     *
     * @return int
     */
    public function getCpu()
    {
        return $this->cpu;
    }

    /**
     * Set memory
     *
     * @param integer $memory
     * @return Offer
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * Get memory
     *
     * @return integer 
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Set storage
     *
     * @param integer $storage
     * @return Offer
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * Get storage
     *
     * @return integer 
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set Nb Vm
     *
     * @param integer $nbVm
     * @return Offer
     */
    public function setNbVm($nbVm)
    {
        $this->nbVm = $nbVm;

        return $this;
    }

    /**
     * Get Nb vm
     *
     * @return integer
     */
    public function getNbVm()
    {
        return $this->nbVm;
    }

    /**
     * Get platforms
     *
     * @return ArrayCollection
     */
    public function getPlatforms()
    {
        return $this->platforms;
    }

    public function toArray()
    {
        return array(
            "code"      => $this->getCode(),
            "name"      => $this->getName(),
            "cpu"       => $this->getCpu(),
            "memory"    => $this->getMemory(),
            "storage"  => $this->getStorage()
        );
    }
}
