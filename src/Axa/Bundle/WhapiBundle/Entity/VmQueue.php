<?php

namespace Axa\Bundle\WhapiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * VmQueue
 *
 * @ORM\Table(name="vm_queue")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\VmQueueRepository")
 */
class VmQueue
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
     * @ORM\Column(name="name", type="string", nullable=false, unique=true)
     *
     */
    private $name;


    /**
     * @var Vm
     *
     * @ORM\OneToOne(targetEntity="Vm", inversedBy="queue")
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
     * Set Vm
     *
     * @param Vm $vm
     * @return VmQueue
     */
    public function setVm(Vm $vm)
    {
        $this->vm = $vm;

        return $this;
    }

    /**
     * Get Vm
     *
     * @return VmQueue
     */
    public function getVm()
    {
        return $this->vm;
    }

    /**
     * Set name
     *
     * @param $name
     * @return VmQueue
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
}
