<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;




/**
 * station
 */
 
class Station
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $stationName;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $geometryType;

    /**
     * @var geometry
     */
    private $theGeom;

    /**
     * @var float
     */
    private $radius;

    /**
     * @var string
     */
    private $intersection;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $birds;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->birds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->species = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set stationName
     *
     * @param string $stationName
     * @return Station
     */
    public function setStationName($stationName)
    {
        $this->stationName = $stationName;
    
        return $this;
    }

    /**
     * Get stationName
     *
     * @return string 
     */
    public function getStationName()
    {
        return $this->stationName;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Station
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
     * Set geometryType
     *
     * @param string $geometryType
     * @return Station
     */
    public function setGeometryType($geometryType)
    {
        $this->geometryType = $geometryType;
    
        return $this;
    }

    /**
     * Get geometryType
     *
     * @return string 
     */
    public function getGeometryType()
    {
        return $this->geometryType;
    }

    /**
     * Set theGeom
     *
     * @param geometry $theGeom
     * @return Station
     */
    public function setTheGeom($theGeom)
    {
        $this->theGeom = $theGeom;
    
        return $this;
    }

    /**
     * Get theGeom
     *
     * @return geometry 
     */
    public function getTheGeom()
    {
        return $this->theGeom;
    }

    /**
     * Set radius
     *
     * @param float $radius
     * @return Station
     */
    public function setRadius($radius)
    {
        $this->radius = $radius;
    
        return $this;
    }

    /**
     * Get radius
     *
     * @return float 
     */
    public function getRadius()
    {
        return $this->radius;
    }

    /**
     * Set intersection
     *
     * @param string $intersection
     * @return Station
     */
    public function setIntersection($intersection)
    {
        $this->intersection = $intersection;
    
        return $this;
    }

    /**
     * Get intersection
     *
     * @return string 
     */
    public function getIntersection()
    {
        return $this->intersection;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Station
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Station
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Station
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add birds
     *
     * @param \Yorku\JuturnaBundle\Entity\Bird $birds
     * @return Station
     */
    public function addBird(\Yorku\JuturnaBundle\Entity\Bird $birds)
    {
        $this->birds[] = $birds;
    
        return $this;
    }

    /**
     * Remove birds
     *
     * @param \Yorku\JuturnaBundle\Entity\Bird $birds
     */
    public function removeBird(\Yorku\JuturnaBundle\Entity\Bird $birds)
    {
        $this->birds->removeElement($birds);
    }

    /**
     * Get birds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBirds()
    {
        return $this->birds;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return Station
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bird_observations;


    /**
     * Add bird_observations
     *
     * @param \Yorku\JuturnaBundle\Entity\BirdObservation $birdObservations
     * @return Station
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
   
 
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $species;


    /**
     * Add species
     *
     * @param \Yorku\JuturnaBundle\Entity\Species $species
     * @return Station
     */
    public function addSpecie(\Yorku\JuturnaBundle\Entity\Species $species)
    {
        $this->species[] = $species;
    
        return $this;
    }

    /**
     * Remove species
     *
     * @param \Yorku\JuturnaBundle\Entity\Species $species
     */
    public function removeSpecie(\Yorku\JuturnaBundle\Entity\Species $species)
    {
        $this->species->removeElement($species);
    }

    /**
     * Get species
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpecies()
    {
        return $this->species;
    }
    public function __toString()
    {
      return $this->stationName;
    }
    /**
     * @var float
     */
    private $lng;

    /**
     * @var float
     */
    private $lat;


    /**
     * Set lng
     *
     * @param float $lng
     * @return Station
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    
        return $this;
    }

    /**
     * Get lng
     *
     * @return float 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set lat
     *
     * @param float $lat
     * @return Station
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    
        return $this;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $observations;


    /**
     * Add observations
     *
     * @param \Yorku\JuturnaBundle\Entity\BirdObservation $observations
     * @return Station
     */
    public function addObservation(\Yorku\JuturnaBundle\Entity\BirdObservation $observations)
    {
        $this->observations[] = $observations;
    
        return $this;
    }

    /**
     * Remove observations
     *
     * @param \Yorku\JuturnaBundle\Entity\BirdObservation $observations
     */
    public function removeObservation(\Yorku\JuturnaBundle\Entity\BirdObservation $observations)
    {
        $this->observations->removeElement($observations);
    }

    /**
     * Get observations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObservations()
    {
        return $this->observations;
    }
}