<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Systemparams
 */
class Systemparams
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $logo1Name;

    /**
     * @var string
     */
    private $logo2Name;

    /**
     * @var string
     */
    private $logo3Name;

    /**
     * @var string
     */
    private $logo1Blob;

    /**
     * @var string
     */
    private $logo2Blob;

    /**
     * @var string
     */
    private $logo3Blob;

    /**
     * @var string
     */
    private $logo1Url;

    /**
     * @var string
     */
    private $logo2Url;

    /**
     * @var string
     */
    private $logo3Url;

    /**
     * @var string
     */
    private $logo1Imagetype;

    /**
     * @var string
     */
    private $logo2Imagetype;

    /**
     * @var string
     */
    private $logo3Imagetype;

    /**
     * @var string
     */
    private $logo1Filename;

    /**
     * @var string
     */
    private $logo2Filename;

    /**
     * @var string
     */
    private $logo3Filename;

    /**
     * @var string
     */
    private $masteremail;

    /**
     * @var string
     */
    private $geoserverHost;

    /**
     * @var integer
     */
    private $geoserverPort;

    /**
     * @var string
     */
    private $geoserverWorkspace;


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
     * Set logo1Name
     *
     * @param string $logo1Name
     * @return Systemparams
     */
    public function setLogo1Name($logo1Name)
    {
        $this->logo1Name = $logo1Name;
    
        return $this;
    }

    /**
     * Get logo1Name
     *
     * @return string 
     */
    public function getLogo1Name()
    {
        return $this->logo1Name;
    }

    /**
     * Set logo2Name
     *
     * @param string $logo2Name
     * @return Systemparams
     */
    public function setLogo2Name($logo2Name)
    {
        $this->logo2Name = $logo2Name;
    
        return $this;
    }

    /**
     * Get logo2Name
     *
     * @return string 
     */
    public function getLogo2Name()
    {
        return $this->logo2Name;
    }

    /**
     * Set logo3Name
     *
     * @param string $logo3Name
     * @return Systemparams
     */
    public function setLogo3Name($logo3Name)
    {
        $this->logo3Name = $logo3Name;
    
        return $this;
    }

    /**
     * Get logo3Name
     *
     * @return string 
     */
    public function getLogo3Name()
    {
        return $this->logo3Name;
    }

    /**
     * Set logo1Blob
     *
     * @param string $logo1Blob
     * @return Systemparams
     */
    public function setLogo1Blob($logo1Blob)
    {
        $this->logo1Blob = $logo1Blob;
    
        return $this;
    }

    /**
     * Get logo1Blob
     *
     * @return string 
     */
    public function getLogo1Blob()
    {
        return $this->logo1Blob;
    }

    /**
     * Set logo2Blob
     *
     * @param string $logo2Blob
     * @return Systemparams
     */
    public function setLogo2Blob($logo2Blob)
    {
        $this->logo2Blob = $logo2Blob;
    
        return $this;
    }

    /**
     * Get logo2Blob
     *
     * @return string 
     */
    public function getLogo2Blob()
    {
        return $this->logo2Blob;
    }

    /**
     * Set logo3Blob
     *
     * @param string $logo3Blob
     * @return Systemparams
     */
    public function setLogo3Blob($logo3Blob)
    {
        $this->logo3Blob = $logo3Blob;
    
        return $this;
    }

    /**
     * Get logo3Blob
     *
     * @return string 
     */
    public function getLogo3Blob()
    {
        return $this->logo3Blob;
    }

    /**
     * Set logo1Url
     *
     * @param string $logo1Url
     * @return Systemparams
     */
    public function setLogo1Url($logo1Url)
    {
        $this->logo1Url = $logo1Url;
    
        return $this;
    }

    /**
     * Get logo1Url
     *
     * @return string 
     */
    public function getLogo1Url()
    {
        return $this->logo1Url;
    }

    /**
     * Set logo2Url
     *
     * @param string $logo2Url
     * @return Systemparams
     */
    public function setLogo2Url($logo2Url)
    {
        $this->logo2Url = $logo2Url;
    
        return $this;
    }

    /**
     * Get logo2Url
     *
     * @return string 
     */
    public function getLogo2Url()
    {
        return $this->logo2Url;
    }

    /**
     * Set logo3Url
     *
     * @param string $logo3Url
     * @return Systemparams
     */
    public function setLogo3Url($logo3Url)
    {
        $this->logo3Url = $logo3Url;
    
        return $this;
    }

    /**
     * Get logo3Url
     *
     * @return string 
     */
    public function getLogo3Url()
    {
        return $this->logo3Url;
    }

    /**
     * Set logo1Imagetype
     *
     * @param string $logo1Imagetype
     * @return Systemparams
     */
    public function setLogo1Imagetype($logo1Imagetype)
    {
        $this->logo1Imagetype = $logo1Imagetype;
    
        return $this;
    }

    /**
     * Get logo1Imagetype
     *
     * @return string 
     */
    public function getLogo1Imagetype()
    {
        return $this->logo1Imagetype;
    }

    /**
     * Set logo2Imagetype
     *
     * @param string $logo2Imagetype
     * @return Systemparams
     */
    public function setLogo2Imagetype($logo2Imagetype)
    {
        $this->logo2Imagetype = $logo2Imagetype;
    
        return $this;
    }

    /**
     * Get logo2Imagetype
     *
     * @return string 
     */
    public function getLogo2Imagetype()
    {
        return $this->logo2Imagetype;
    }

    /**
     * Set logo3Imagetype
     *
     * @param string $logo3Imagetype
     * @return Systemparams
     */
    public function setLogo3Imagetype($logo3Imagetype)
    {
        $this->logo3Imagetype = $logo3Imagetype;
    
        return $this;
    }

    /**
     * Get logo3Imagetype
     *
     * @return string 
     */
    public function getLogo3Imagetype()
    {
        return $this->logo3Imagetype;
    }

    /**
     * Set logo1Filename
     *
     * @param string $logo1Filename
     * @return Systemparams
     */
    public function setLogo1Filename($logo1Filename)
    {
        $this->logo1Filename = $logo1Filename;
    
        return $this;
    }

    /**
     * Get logo1Filename
     *
     * @return string 
     */
    public function getLogo1Filename()
    {
        return $this->logo1Filename;
    }

    /**
     * Set logo2Filename
     *
     * @param string $logo2Filename
     * @return Systemparams
     */
    public function setLogo2Filename($logo2Filename)
    {
        $this->logo2Filename = $logo2Filename;
    
        return $this;
    }

    /**
     * Get logo2Filename
     *
     * @return string 
     */
    public function getLogo2Filename()
    {
        return $this->logo2Filename;
    }

    /**
     * Set logo3Filename
     *
     * @param string $logo3Filename
     * @return Systemparams
     */
    public function setLogo3Filename($logo3Filename)
    {
        $this->logo3Filename = $logo3Filename;
    
        return $this;
    }

    /**
     * Get logo3Filename
     *
     * @return string 
     */
    public function getLogo3Filename()
    {
        return $this->logo3Filename;
    }

    /**
     * Set masteremail
     *
     * @param string $masteremail
     * @return Systemparams
     */
    public function setMasteremail($masteremail)
    {
        $this->masteremail = $masteremail;
    
        return $this;
    }

    /**
     * Get masteremail
     *
     * @return string 
     */
    public function getMasteremail()
    {
        return $this->masteremail;
    }

    /**
     * Set geoserverHost
     *
     * @param string $geoserverHost
     * @return Systemparams
     */
    public function setGeoserverHost($geoserverHost)
    {
        $this->geoserverHost = $geoserverHost;
    
        return $this;
    }

    /**
     * Get geoserverHost
     *
     * @return string 
     */
    public function getGeoserverHost()
    {
        return $this->geoserverHost;
    }

    /**
     * Set geoserverPort
     *
     * @param integer $geoserverPort
     * @return Systemparams
     */
    public function setGeoserverPort($geoserverPort)
    {
        $this->geoserverPort = $geoserverPort;
    
        return $this;
    }

    /**
     * Get geoserverPort
     *
     * @return integer 
     */
    public function getGeoserverPort()
    {
        return $this->geoserverPort;
    }

    /**
     * Set geoserverWorkspace
     *
     * @param string $geoserverWorkspace
     * @return Systemparams
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
}
