<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bird
 */
class Bird
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $birdname;

    /**
     * @var string
     */
    private $imageName;

    /**
     * @var string
     */
    private $imagePath;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $websiteUrl;

    /**
     * @var string
     */
    private $imageTip;

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
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;


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
     * Set birdname
     *
     * @param string $birdname
     * @return Bird
     */
    public function setBirdname($birdname)
    {
        $this->birdname = $birdname;
    
        return $this;
    }

    /**
     * Get birdname
     *
     * @return string 
     */
    public function getBirdname()
    {
        return $this->birdname;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Bird
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    
        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set imagePath
     *
     * @param string $imagePath
     * @return Bird
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    
        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string 
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Bird
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
     * Set websiteUrl
     *
     * @param string $websiteUrl
     * @return Bird
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;
    
        return $this;
    }

    /**
     * Get websiteUrl
     *
     * @return string 
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * Set imageTip
     *
     * @param string $imageTip
     * @return Bird
     */
    public function setImageTip($imageTip)
    {
        $this->imageTip = $imageTip;
    
        return $this;
    }

    /**
     * Get imageTip
     *
     * @return string 
     */
    public function getImageTip()
    {
        return $this->imageTip;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Bird
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
     * @return Bird
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
     * @return Bird
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Bird
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
     * @return Bird
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
     * @var geometry
     */
    private $theGeom;


    /**
     * Set theGeom
     *
     * @param geometry $theGeom
     * @return Bird
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
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return Bird
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
     * @var string
     */
    private $imageFilename;


    /**
     * Set imageFilename
     *
     * @param string $imageFilename
     * @return Bird
     */
    public function setImageFilename($imageFilename)
    {
        $this->imageFilename = $imageFilename;
    
        return $this;
    }

    /**
     * Get imageFilename
     *
     * @return string 
     */
    public function getImageFilename()
    {
        return $this->imageFilename;
    }
    /**
     * @var \Yorku\JuturnaBundle\Entity\Station
     */
    private $station;


    /**
     * Set station
     *
     * @param \Yorku\JuturnaBundle\Entity\Station $station
     * @return Bird
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
     * @var string
     */
    private $scientificName;

    /**
     * @var string
     */
    private $commonName;

    /**
     * @var string
     */
    private $iucn;

    /**
     * @var string
     */
    private $season;

    /**
     * @var string
     */
    private $distribution;

    /**
     * @var string
     */
    private $rareness;

    /**
     * @var string
     */
    private $code;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $observations;

    /**
     * @var \Yorku\JuturnaBundle\Entity\Family
     */
    private $family;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->observations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set scientificName
     *
     * @param string $scientificName
     * @return Bird
     */
    public function setScientificName($scientificName)
    {
        $this->scientificName = $scientificName;
    
        return $this;
    }

    /**
     * Get scientificName
     *
     * @return string 
     */
    public function getScientificName()
    {
        return $this->scientificName;
    }

    /**
     * Set commonName
     *
     * @param string $commonName
     * @return Bird
     */
    public function setCommonName($commonName)
    {
        $this->commonName = $commonName;
    
        return $this;
    }

    /**
     * Get commonName
     *
     * @return string 
     */
    public function getCommonName()
    {
        return $this->commonName;
    }

    /**
     * Set iucn
     *
     * @param string $iucn
     * @return Bird
     */
    public function setIucn($iucn)
    {
        $this->iucn = $iucn;
    
        return $this;
    }

    /**
     * Get iucn
     *
     * @return string 
     */
    public function getIucn()
    {
        return $this->iucn;
    }

    /**
     * Set season
     *
     * @param string $season
     * @return Bird
     */
    public function setSeason($season)
    {
        $this->season = $season;
    
        return $this;
    }

    /**
     * Get season
     *
     * @return string 
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set distribution
     *
     * @param string $distribution
     * @return Bird
     */
    public function setDistribution($distribution)
    {
        $this->distribution = $distribution;
    
        return $this;
    }

    /**
     * Get distribution
     *
     * @return string 
     */
    public function getDistribution()
    {
        return $this->distribution;
    }

    /**
     * Set rareness
     *
     * @param string $rareness
     * @return Bird
     */
    public function setRareness($rareness)
    {
        $this->rareness = $rareness;
    
        return $this;
    }

    /**
     * Get rareness
     *
     * @return string 
     */
    public function getRareness()
    {
        return $this->rareness;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Bird
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
     * Add observations
     *
     * @param \Yorku\JuturnaBundle\Entity\BirdObservation $observations
     * @return Bird
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

    /**
     * Set family
     *
     * @param \Yorku\JuturnaBundle\Entity\Family $family
     * @return Bird
     */
    public function setFamily(\Yorku\JuturnaBundle\Entity\Family $family = null)
    {
        $this->family = $family;
    
        return $this;
    }

    /**
     * Get family
     *
     * @return \Yorku\JuturnaBundle\Entity\Family 
     */
    public function getFamily()
    {
        return $this->family;
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
     * @return Bird
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
     * @return Bird
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
     * @return Bird
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
}