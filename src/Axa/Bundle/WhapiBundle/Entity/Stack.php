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
 * Stack
 *
 * @ORM\Table(name="stack")
 * @ORM\Entity(repositoryClass="Axa\Bundle\WhapiBundle\Entity\StackRepository")
 * @ExclusionPolicy("all")
 */
class Stack
{

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @var integer
     * @Expose
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Expose
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Expose
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var boolean
     * @Expose
     * @ORM\Column(name="isWeb", type="boolean")
     */
    private $isWeb;

    /**
     * @var string
     * @Expose
     * @ORM\Column(name="repository", type="string")
     */
    private $repository;

    /**
     * @ORM\OneToMany(targetEntity="Application", mappedBy="stack")
     */
    private $applications;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
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
     * Set description
     *
     * @param string $description
     * @return Stack
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isWeb
     *
     * @param boolean $isWeb
     * @return Stack
     */
    public function setIsWeb($isWeb)
    {
        $this->isWeb = $isWeb;

        return $this;
    }

    /**
     * Set isWeb
     *
     *
     * @return Stack
     */
    public function isWeb()
    {
        return $this->isWeb;
    }

    /**
     * Set repository
     *
     * @param string $repository
     * @return Stack
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Get repository
     *
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }
}
