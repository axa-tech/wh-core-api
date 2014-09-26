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
