<?php

namespace Axa\Bundle\WhapiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PlatformMetadata
 *
 * @ORM\Table(name="platformmetadata")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\PlatformMetadataRepository")
 */
class PlatformMetadata
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
     * @ORM\Column(name="name", type="string", nullable=false, unique=true, length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Platform", inversedBy="metadata")
     */
    private $platform;


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
     * Set platform
     *
     * @param Platform platform
     * @return PlatformMetadata
     */
    public function setPlatform(Platform $platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * Get platform
     *
     * @return Platform
     */
    public function getPlatform()
    {
        return $this->platform;
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
