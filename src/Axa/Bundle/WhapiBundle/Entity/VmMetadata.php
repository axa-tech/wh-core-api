<?php

namespace Axa\Bundle\WhapiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VmMetadata
 *
 * @ORM\Table(name="vmmetadata")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\VmMetadataRepository")
 */
class VmMetadata
{
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
     * @ORM\Column(name="name", type="string", nullable=false, length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Vm", inversedBy="metadata")
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
     * Set vm
     *
     * @param string $vm
     * @return VmMetadata
     */
    public function setVm($vm)
    {
        $this->vm = $vm;

        return $this;
    }

    /**
     * Get vm
     *
     * @return string 
     */
    public function getVm()
    {
        return $this->vm;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return VmMetadata
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
     * Set value
     *
     * @param string $value
     * @return VmMetadata
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }
}
