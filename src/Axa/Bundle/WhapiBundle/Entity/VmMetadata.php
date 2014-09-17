<?php

namespace Axa\Bundle\WhapiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * VmMetadata
 *
 * @ORM\Table(name="vmmetadata")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\VmMetadataRepository")
 */
class VmMetadata
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

    /**
     * Displays the name and value properties
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name . " : " . $this->value;
    }

    /**
     * Returns the name and value properties in an array format
     *
     * @return array
     */
    public function toArray()
    {
        return array("name" => $this->name, "value" => $this->value);
    }
}
