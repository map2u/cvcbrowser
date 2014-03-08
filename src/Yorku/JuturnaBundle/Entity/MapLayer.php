<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MapLayer
 */
class MapLayer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $layerTitle;

    /**
     * @var string
     */
    private $layerName;

    /**
     * @var string
     */
    private $WMSUrl;

    /**
     * @var string
     */
    private $geoserverWorkspace;

    /**
     * @var string
     */
    private $geoserverLayerName;

    /**
     * @var string
     */
    private $layerType;

    /**
     * @var boolean
     */
    private $layerEnabled;

    /**
     * @var boolean
     */
    private $layerShowInSwitcher;

    /**
     * @var string
     */
    private $layerEPSG;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set layerTitle
     *
     * @param string $layerTitle
     * @return MapLayer
     */
    public function setLayerTitle($layerTitle)
    {
        $this->layerTitle = $layerTitle;
    
        return $this;
    }

    /**
     * Get layerTitle
     *
     * @return string 
     */
    public function getLayerTitle()
    {
        return $this->layerTitle;
    }

    /**
     * Set layerName
     *
     * @param string $layerName
     * @return MapLayer
     */
    public function setLayerName($layerName)
    {
        $this->layerName = $layerName;
    
        return $this;
    }

    /**
     * Get layerName
     *
     * @return string 
     */
    public function getLayerName()
    {
        return $this->layerName;
    }

    /**
     * Set WMSUrl
     *
     * @param string $wMSUrl
     * @return MapLayer
     */
    public function setWMSUrl($wMSUrl)
    {
        $this->WMSUrl = $wMSUrl;
    
        return $this;
    }

    /**
     * Get WMSUrl
     *
     * @return string 
     */
    public function getWMSUrl()
    {
        return $this->WMSUrl;
    }

    /**
     * Set geoserverWorkspace
     *
     * @param string $geoserverWorkspace
     * @return MapLayer
     */
    public function setGeoserverWorkspace($geoserverWorkspace)
    {
        $this->geoserverWorkspace = $geoserverWorkspace;
    
        return $this;
    }

    /**
     * Get geoserverWorkspace
     *
     * @return string 
     */
    public function getGeoserverWorkspace()
    {
        return $this->geoserverWorkspace;
    }

    /**
     * Set geoserverLayerName
     *
     * @param string $geoserverLayerName
     * @return MapLayer
     */
    public function setGeoserverLayerName($geoserverLayerName)
    {
        $this->geoserverLayerName = $geoserverLayerName;
    
        return $this;
    }

    /**
     * Get geoserverLayerName
     *
     * @return string 
     */
    public function getGeoserverLayerName()
    {
        return $this->geoserverLayerName;
    }

    /**
     * Set layerType
     *
     * @param string $layerType
     * @return MapLayer
     */
    public function setLayerType($layerType)
    {
        $this->layerType = $layerType;
    
        return $this;
    }

    /**
     * Get layerType
     *
     * @return string 
     */
    public function getLayerType()
    {
        return $this->layerType;
    }

    /**
     * Set layerEnabled
     *
     * @param boolean $layerEnabled
     * @return MapLayer
     */
    public function setLayerEnabled($layerEnabled)
    {
        $this->layerEnabled = $layerEnabled;
    
        return $this;
    }

    /**
     * Get layerEnabled
     *
     * @return boolean 
     */
    public function getLayerEnabled()
    {
        return $this->layerEnabled;
    }

    /**
     * Set layerShowInSwitcher
     *
     * @param boolean $layerShowInSwitcher
     * @return MapLayer
     */
    public function setLayerShowInSwitcher($layerShowInSwitcher)
    {
        $this->layerShowInSwitcher = $layerShowInSwitcher;
    
        return $this;
    }

    /**
     * Get layerShowInSwitcher
     *
     * @return boolean 
     */
    public function getLayerShowInSwitcher()
    {
        return $this->layerShowInSwitcher;
    }

    /**
     * Set layerEPSG
     *
     * @param string $layerEPSG
     * @return MapLayer
     */
    public function setLayerEPSG($layerEPSG)
    {
        $this->layerEPSG = $layerEPSG;
    
        return $this;
    }

    /**
     * Get layerEPSG
     *
     * @return string 
     */
    public function getLayerEPSG()
    {
        return $this->layerEPSG;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MapLayer
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
     * @return MapLayer
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
     * @return MapLayer
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
}
