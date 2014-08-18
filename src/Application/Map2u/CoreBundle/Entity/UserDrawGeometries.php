<?php

namespace Application\Map2u\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Map2u\CoreBundle\Entity\BaseUserDrawGeometries as BaseUserDrawGeometries;

/**
 * @ORM\Entity
 */
class UserDrawGeometries extends BaseUserDrawGeometries {

 
  protected $id;

  /**
   * @ORM\Column(type="string", length=250, nullable=true)
   */
  protected $images;

  /**
   * @ORM\Column(type="string", length=250, nullable=true)
   */
  protected $video;

  /**
   * @ORM\Column(type="string", length=250, nullable=true)
   */
  protected $audio;

  /**
   * Get id
   *
   * @return integer $id
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set images
   *
   * @param string $images
   * @return UserDrawGeometries
   */
  public function setImages($images) {
    $this->images = $images;

    return $this;
  }

  /**
   * Get images
   *
   * @return string 
   */
  public function getImages() {
    return $this->images;
  }

  /**
   * Set video
   *
   * @param string $video
   * @return UserDrawGeometries
   */
  public function setVideo($video) {
    $this->video = $video;

    return $this;
  }

  /**
   * Get video
   *
   * @return string 
   */
  public function getVideo() {
    return $this->video;
  }

  /**
   * Set aaudio
   *
   * @param string $audio
   * @return UserDrawGeometries
   */
  public function setAudio($audio) {
    $this->audio = $audio;

    return $this;
  }

  /**
   * Get audio
   *
   * @return string 
   */
  public function getAudio() {
    return $this->audio;
  }

  public function __toString() {
    return $this->getName();
  }

  public function __construct() {
    parent::__construct();
  }

}
