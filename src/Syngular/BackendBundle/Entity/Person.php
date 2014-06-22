<?php

namespace Syngular\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints AS Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="Person")
 */
class Person extends AbstractEntity
{
    
    public function __construct()
    {
        $this->injections = new ArrayCollection;
    }
    
    /**
     * @var string $name
     * 
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(min = 4, max = 10)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $address;
    
    /**
     * @ORM\OneToMany(targetEntity="Injection", mappedBy="person")
     */
    private $injections;
    
    /**
     * Set name
     *
     * @param string $name
     * @return Person
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
     * Set address
     *
     * @param string $address
     * @return Person
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add injections
     *
     * @param \Syngular\BackendBundle\Entity\Injection $injections
     * @return Person
     */
    public function addInjection(\Syngular\BackendBundle\Entity\Injection $injections)
    {
        $this->injections[] = $injections;

        return $this;
    }

    /**
     * Remove injections
     *
     * @param \Syngular\BackendBundle\Entity\Injection $injections
     */
    public function removeInjection(\Syngular\BackendBundle\Entity\Injection $injections)
    {
        $this->injections->removeElement($injections);
    }

    /**
     * Get injections
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInjections()
    {
        return $this->injections;
    }
}
