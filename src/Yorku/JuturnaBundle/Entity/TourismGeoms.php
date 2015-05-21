<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TourismGeoms
 */
class TourismGeoms
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
    private $label;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var boolean
     */
    private $isEnabled;

    /**
     * @var boolean
     */
    private $isPublished;

    /**
     * @var geometry
     */
    private $theGeom;

    /**
     * @var string
     */
    private $geometryType;

    /**
     * @var float
     */
    private $radius;

    /**
     * @var string
     */
    private $style;

    /**
     * @var \Yorku\JuturnaBundle\Entity\Tourism
     */
    private $tourism;


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
     * @return TourismGeoms
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
     * Set label
     *
     * @param string $label
     * @return TourismGeoms
     */
    public function setLabel($label)
    {
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return TourismGeoms
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    
        return $this;
    }

    /**
     * Get icon
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     * @return TourismGeoms
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    
        return $this;
    }

    /**
     * Get isEnabled
     *
     * @return boolean 
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Set isPublished
     *
     * @param boolean $isPublished
     * @return TourismGeoms
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    
        return $this;
    }

    /**
     * Get isPublished
     *
     * @return boolean 
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Set theGeom
     *
     * @param geometry $theGeom
     * @return TourismGeoms
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
     * Set geometryType
     *
     * @param string $geometryType
     * @return TourismGeoms
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
     * Set radius
     *
     * @param float $radius
     * @return TourismGeoms
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
     * Set style
     *
     * @param string $style
     * @return TourismGeoms
     */
    public function setStyle($style)
    {
        $this->style = $style;
    
        return $this;
    }

    /**
     * Get style
     *
     * @return string 
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set tourism
     *
     * @param \Yorku\JuturnaBundle\Entity\Tourism $tourism
     * @return TourismGeoms
     */
    public function setTourism(\Yorku\JuturnaBundle\Entity\Tourism $tourism = null)
    {
        $this->tourism = $tourism;
    
        return $this;
    }

    /**
     * Get tourism
     *
     * @return \Yorku\JuturnaBundle\Entity\Tourism 
     */
    public function getTourism()
    {
        return $this->tourism;
    }
    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return TourismGeoms
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
    public function __toString()
    {
      return $this->name;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tourisms;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tourisms = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add tourisms
     *
     * @param \Yorku\JuturnaBundle\Entity\Tourism $tourisms
     * @return TourismGeoms
     */
    public function addTourism(\Yorku\JuturnaBundle\Entity\Tourism $tourisms)
    {
        $this->tourisms[] = $tourisms;
    
        return $this;
    }

    /**
     * Remove tourisms
     *
     * @param \Yorku\JuturnaBundle\Entity\Tourism $tourisms
     */
    public function removeTourism(\Yorku\JuturnaBundle\Entity\Tourism $tourisms)
    {
        $this->tourisms->removeElement($tourisms);
    }

    /**
     * Get tourisms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTourisms()
    {
        return $this->tourisms;
    }
}