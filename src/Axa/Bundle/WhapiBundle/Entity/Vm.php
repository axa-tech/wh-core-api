<?php

namespace Axa\Bundle\WhapiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vm
 *
 * @ORM\Table(name="vm")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\VmRepository")
 */
class Vm
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
     * @ORM\ManyToOne(targetEntity="Platform", inversedBy="virtualMachines")
     * @ORM\JoinColumn(name="platform_id", referencedColumnName="id")
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
