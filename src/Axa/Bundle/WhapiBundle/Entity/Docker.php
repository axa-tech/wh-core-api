<?php

namespace Axa\Bundle\WhapiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Docker
 *
 * @ORM\Table(name="docker")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\DockerRepository")
 */
class Docker
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
     * @ORM\Column(name="code", type="string", unique=true, length=10)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", unique=true, length=255)
     */
    private $name;


    /**
     * @ORM\ManyToMany(targetEntity="Vm", mappedBy="dockers")
     */
    private $vms;


    public function __construct()
    {
        $this->vms = new ArrayCollection();
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
     * @return Docker
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
     * @return Docker
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
     * Get vms
     *
     * @return ArrayCollection
     */
    public function getPlatVms()
    {
        return $this->vms;
    }

    /**
     * Add new vm
     *
     * @param Vm $vm
     * @return Docker
     */
    public function addVm(Vm $vm)
    {
        $this->vms->add($vm);

        return $this;
    }
}
