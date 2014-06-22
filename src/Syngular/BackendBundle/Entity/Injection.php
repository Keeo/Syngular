<?php

namespace Syngular\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints AS Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="Injection")
 */
class Injection extends AbstractEntity
{
    /**
     * @var string $name
     * 
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Length(min = 4, max = 20)
     */
    private $name;
    
    /**
     * @var string $illness
     * 
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(min = 4, max = 100)
     */
    private $illness;
    
    /**
     * @var int $code
     * 
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Length(min = 10, max = 10)
     */
    private $code;
    

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="injections")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;
    
    /**
     * Set name
     *
     * @param string $name
     * @return Injection
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
     * Set illness
     *
     * @param string $illness
     * @return Injection
     */
    public function setIllness($illness)
    {
        $this->illness = $illness;

        return $this;
    }

    /**
     * Get illness
     *
     * @return string 
     */
    public function getIllness()
    {
        return $this->illness;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Injection
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
     * Set person
     *
     * @param \Syngular\BackendBundle\Entity\Person $person
     * @return Injection
     */
    public function setPerson(\Syngular\BackendBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \Syngular\BackendBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }
}
