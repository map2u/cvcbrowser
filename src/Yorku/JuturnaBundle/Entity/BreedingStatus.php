<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BreedingStatus
 */
class BreedingStatus
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $description;


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
     * @return BreedingStatus
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
     * Set code
     *
     * @param string $code
     * @return BreedingStatus
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
     * Set description
     *
     * @param string $description
     * @return BreedingStatus
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bird_observations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bird_observations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add bird_observations
     *
     * @param \Yorku\JuturnaBundle\Entity\BirdObservation $birdObservations
     * @return BreedingStatus
     */
    public function addBirdObservation(\Yorku\JuturnaBundle\Entity\BirdObservation $birdObservations)
    {
        $this->bird_observations[] = $birdObservations;
    
        return $this;
    }

    /**
     * Remove bird_observations
     *
     * @param \Yorku\JuturnaBundle\Entity\BirdObservation $birdObservations
     */
    public function removeBirdObservation(\Yorku\JuturnaBundle\Entity\BirdObservation $birdObservations)
    {
        $this->bird_observations->removeElement($birdObservations);
    }

    /**
     * Get bird_observations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBirdObservations()
    {
        return $this->bird_observations;
    }
    
     public function __toString()
    {
      return $this->code;
    }
}