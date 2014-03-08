<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BirdObservation
 */
class BirdObservation
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var json
     */
    private $images;

    /**
     * @var json
     */
    private $videos;

    /**
     * @var json
     */
    private $audios;

    /**
     * @var boolean
     */
    private $enabled;

    /**
     * @var float
     */
    private $lng;

    /**
     * @var float
     */
    private $lat;

    /**
     * @var string
     */
    private $observationDescription;

    /**
     * @var \DateTime
     */
    private $observedAt;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Yorku\JuturnaBundle\Entity\Species
     */
    private $species;

    /**
     * @var \Yorku\JuturnaBundle\Entity\Station
     */
    private $station;

    /**
     * @var \Yorku\JuturnaBundle\Entity\BreedingStatus
     */
    private $breedingStatus;


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
     * Set images
     *
     * @param json $images
     * @return BirdObservation
     */
    public function setImages($images)
    {
        $this->images = $images;
    
        return $this;
    }

    /**
     * Get images
     *
     * @return json 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set videos
     *
     * @param json $videos
     * @return BirdObservation
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;
    
        return $this;
    }

    /**
     * Get videos
     *
     * @return json 
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Set audios
     *
     * @param json $audios
     * @return BirdObservation
     */
    public function setAudios($audios)
    {
        $this->audios = $audios;
    
        return $this;
    }

    /**
     * Get audios
     *
     * @return json 
     */
    public function getAudios()
    {
        return $this->audios;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return BirdObservation
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set lng
     *
     * @param float $lng
     * @return BirdObservation
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
     * @return BirdObservation
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
     * Set observationDescription
     *
     * @param string $observationDescription
     * @return BirdObservation
     */
    public function setObservationDescription($observationDescription)
    {
        $this->observationDescription = $observationDescription;
    
        return $this;
    }

    /**
     * Get observationDescription
     *
     * @return string 
     */
    public function getObservationDescription()
    {
        return $this->observationDescription;
    }

    /**
     * Set observedAt
     *
     * @param \DateTime $observedAt
     * @return BirdObservation
     */
    public function setObservedAt($observedAt)
    {
        $this->observedAt = $observedAt;
    
        return $this;
    }

    /**
     * Get observedAt
     *
     * @return \DateTime 
     */
    public function getObservedAt()
    {
        return $this->observedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return BirdObservation
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
     * @return BirdObservation
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
     * Set description
     *
     * @param string $description
     * @return BirdObservation
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
     * Set species
     *
     * @param \Yorku\JuturnaBundle\Entity\Species $species
     * @return BirdObservation
     */
    public function setSpecies(\Yorku\JuturnaBundle\Entity\Species $species = null)
    {
        $this->species = $species;
    
        return $this;
    }

    /**
     * Get species
     *
     * @return \Yorku\JuturnaBundle\Entity\Species 
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * Set station
     *
     * @param \Yorku\JuturnaBundle\Entity\Station $station
     * @return BirdObservation
     */
    public function setStation(\Yorku\JuturnaBundle\Entity\Station $station = null)
    {
        $this->station = $station;
    
        return $this;
    }

    /**
     * Get station
     *
     * @return \Yorku\JuturnaBundle\Entity\Station 
     */
    public function getStation()
    {
        return $this->station;
    }

    /**
     * Set breedingStatus
     *
     * @param \Yorku\JuturnaBundle\Entity\BreedingStatus $breedingStatus
     * @return BirdObservation
     */
    public function setBreedingStatus(\Yorku\JuturnaBundle\Entity\BreedingStatus $breedingStatus = null)
    {
        $this->breedingStatus = $breedingStatus;
    
        return $this;
    }

    /**
     * Get breedingStatus
     *
     * @return \Yorku\JuturnaBundle\Entity\BreedingStatus 
     */
    public function getBreedingStatus()
    {
        return $this->breedingStatus;
    }
     public function __toString()
    {
      return $this->getBreedingStatus()->getCode().$this->observationDescription;
    }

    /**
     * @var \Yorku\JuturnaBundle\Entity\Bird
     */
    private $bird;


    /**
     * Set bird
     *
     * @param \Yorku\JuturnaBundle\Entity\Bird $bird
     * @return BirdObservation
     */
    public function setBird(\Yorku\JuturnaBundle\Entity\Bird $bird = null)
    {
        $this->bird = $bird;
    
        return $this;
    }

    /**
     * Get bird
     *
     * @return \Yorku\JuturnaBundle\Entity\Bird 
     */
    public function getBird()
    {
        return $this->bird;
    }
}