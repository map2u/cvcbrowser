<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Species
 */
class Species {

  /**
   * @var integer
   */
  private $id;

  /**
   * @var string
   */
  private $speciesName;

  /**
   * @var string
   */
  private $description;

  /**
   * @var string
   */
  private $IUCN;

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set id
   *
   * @param integer $id
   * @return Species
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  /**
   * Set speciesName
   *
   * @param string $speciesName
   * @return Species
   */
  public function setSpeciesName($speciesName) {
    $this->speciesName = $speciesName;

    return $this;
  }

  /**
   * Get speciesName
   *
   * @return string 
   */
  public function getSpeciesName() {
    return $this->speciesName;
  }

  /**
   * Set description
   *
   * @param string $description
   * @return Species
   */
  public function setDescription($description) {
    $this->description = $description;

    return $this;
  }

  /**
   * Get description
   *
   * @return string 
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Set IUCN
   *
   * @param string $iUCN
   * @return Species
   */
  public function setIUCN($iUCN) {
    $this->IUCN = $iUCN;

    return $this;
  }

  /**
   * Get IUCN
   *
   * @return string 
   */
  public function getIUCN() {
    return $this->IUCN;
  }

  /**
   * @var string
   */
  private $code;

  /**
   * Set code
   *
   * @param string $code
   * @return Species
   */
  public function setCode($code) {
    $this->code = $code;

    return $this;
  }

  /**
   * Get code
   *
   * @return string 
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * @var \Doctrine\Common\Collections\Collection
   */
  private $bird_observations;

  /**
   * Constructor
   */
  public function __construct() {
    $this->bird_observations = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Add bird_observations
   *
   * @param \Yorku\JuturnaBundle\Entity\BirdObservation $birdObservations
   * @return Species
   */
  public function addBirdObservation(\Yorku\JuturnaBundle\Entity\BirdObservation $birdObservations) {
    $this->bird_observations[] = $birdObservations;

    return $this;
  }

  /**
   * Remove bird_observations
   *
   * @param \Yorku\JuturnaBundle\Entity\BirdObservation $birdObservations
   */
  public function removeBirdObservation(\Yorku\JuturnaBundle\Entity\BirdObservation $birdObservations) {
    $this->bird_observations->removeElement($birdObservations);
  }

  /**
   * Get bird_observations
   *
   * @return \Doctrine\Common\Collections\Collection 
   */
  public function getBirdObservations() {
    return $this->bird_observations;
  }

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
   * Set images
   *
   * @param json $images
   * @return Species
   */
  public function setImages($images) {
    $this->images = $images;

    return $this;
  }

  /**
   * Get images
   *
   * @return json 
   */
  public function getImages() {
    return $this->images;
  }

  /**
   * Set videos
   *
   * @param json $videos
   * @return Species
   */
  public function setVideos($videos) {
    $this->videos = $videos;

    return $this;
  }

  /**
   * Get videos
   *
   * @return json 
   */
  public function getVideos() {
    return $this->videos;
  }

  /**
   * Set audios
   *
   * @param json $audios
   * @return Species
   */
  public function setAudios($audios) {
    $this->audios = $audios;

    return $this;
  }

  /**
   * Get audios
   *
   * @return json 
   */
  public function getAudios() {
    return $this->audios;
  }

  /**
   * @var \Doctrine\Common\Collections\Collection
   */
  private $stations;

  /**
   * Add stations
   *
   * @param \Yorku\JuturnaBundle\Entity\Station $stations
   * @return Species
   */
  public function addStation(\Yorku\JuturnaBundle\Entity\Station $stations) {
    $this->stations[] = $stations;

    return $this;
  }

  /**
   * Remove stations
   *
   * @param \Yorku\JuturnaBundle\Entity\Station $stations
   */
  public function removeStation(\Yorku\JuturnaBundle\Entity\Station $stations) {
    $this->stations->removeElement($stations);
  }

  /**
   * Get stations
   *
   * @return \Doctrine\Common\Collections\Collection 
   */
  public function getStations() {
    return $this->stations;
  }

  public function __toString() {
    return strval($this->id);
  }

}
