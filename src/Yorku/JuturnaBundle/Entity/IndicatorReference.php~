<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IndicatorReference
 */
class IndicatorReference {

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
    private $reference;

    /**
     * @var string
     */
    private $website;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorbenefits;

    /**
     * Constructor
     */
    public function __construct() {
        $this->indicatorbenefits = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return EcoSystemService
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return IndicatorReference
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return IndicatorReference
     */
    public function setReference($reference) {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference() {
        return $this->reference;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return IndicatorReference
     */
    public function setWebsite($website) {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite() {
        return $this->website;
    }

    /**
     * Add indicatorbenefits
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorBenefit $indicatorbenefits
     * @return IndicatorReference
     */
    public function addIndicatorbenefit(\Yorku\JuturnaBundle\Entity\IndicatorBenefit $indicatorbenefits) {
        $this->indicatorbenefits[] = $indicatorbenefits;

        return $this;
    }

    /**
     * Remove indicatorbenefits
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorBenefit $indicatorbenefits
     */
    public function removeIndicatorbenefit(\Yorku\JuturnaBundle\Entity\IndicatorBenefit $indicatorbenefits) {
        $this->indicatorbenefits->removeElement($indicatorbenefits);
    }

    /**
     * Get indicatorbenefits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicatorbenefits() {
        return $this->indicatorbenefits;
    }

    public function __toString() {
        return $this->name;
    }

}
