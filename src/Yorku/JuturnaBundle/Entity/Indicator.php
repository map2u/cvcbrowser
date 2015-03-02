<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Indicator
 */
class Indicator {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

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
     * @return Indicator
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
     * Add indicatorbenefits
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorBenefit $indicatorbenefits
     * @return Indicator
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

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorbenefitimages;

    /**
     * Add indicatorbenefitimages
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorBenefitImage $indicatorbenefitimages
     * @return Indicator
     */
    public function addIndicatorbenefitimage(\Yorku\JuturnaBundle\Entity\IndicatorBenefitImage $indicatorbenefitimages) {
        $this->indicatorbenefitimages[] = $indicatorbenefitimages;

        return $this;
    }

    /**
     * Remove indicatorbenefitimages
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorBenefitImage $indicatorbenefitimages
     */
    public function removeIndicatorbenefitimage(\Yorku\JuturnaBundle\Entity\IndicatorBenefitImage $indicatorbenefitimages) {
        $this->indicatorbenefitimages->removeElement($indicatorbenefitimages);
    }

    /**
     * Get indicatorbenefitimages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicatorbenefitimages() {
        return $this->indicatorbenefitimages;
    }

    public function __toString() {
        return $this->name;
    }

}
