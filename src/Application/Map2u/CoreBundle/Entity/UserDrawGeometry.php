<?php

/**
 * <copyright>
 * This file/program is free and open source software released under the GNU General Public
 * License version 3, and is distributed WITHOUT ANY WARRANTY. A copy of the GNU General
 * Public Licence is available at http://www.gnu.org/licenses
 * </copyright>
 *
 * <author>Shuilin (Joseph) Zhao</author>
 * <company>SpEAR Lab, Faculty of Environmental Studies, York University
 * <email>zhaoshuilin2004@yahoo.ca</email>
 * <date>created at 2014/01/06</date>
 * <date>last updated at 2015/03/11</date>
 * <summary>This is the extend of Map2u\CoreBundle\Entity\BaseUserDrawGeometries entity</summary>
 * <purpose>for entity extend based on Map2u\CoreBundle\Entity\BaseUserDrawGeometries</purpose>
 */

namespace Application\Map2u\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Map2u\CoreBundle\Entity\BaseUserGeometry as BaseUserGeometry;

/**
 * @ORM\Entity
 */
class UserDrawGeometry extends BaseUserGeometry {

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

    /**
     * @var string
     */
    private $altText;


    /**
     * Set altText
     *
     * @param string $altText
     * @return UserDrawGeometries
     */
    public function setAltText($altText)
    {
        $this->altText = $altText;

        return $this;
    }

    /**
     * Get altText
     *
     * @return string 
     */
    public function getAltText()
    {
        return $this->altText;
    }
}
