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

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $additional_indicatorbenefits;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $otherlinks_indicatorbenefits;


    /**
     * Add additional_indicatorbenefits
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorBenefit $additionalIndicatorbenefits
     * @return IndicatorReference
     */
    public function addAdditionalIndicatorbenefit(\Yorku\JuturnaBundle\Entity\IndicatorBenefit $additionalIndicatorbenefits)
    {
        $this->additional_indicatorbenefits[] = $additionalIndicatorbenefits;

        return $this;
    }

    /**
     * Remove additional_indicatorbenefits
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorBenefit $additionalIndicatorbenefits
     */
    public function removeAdditionalIndicatorbenefit(\Yorku\JuturnaBundle\Entity\IndicatorBenefit $additionalIndicatorbenefits)
    {
        $this->additional_indicatorbenefits->removeElement($additionalIndicatorbenefits);
    }

    /**
     * Get additional_indicatorbenefits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdditionalIndicatorbenefits()
    {
        return $this->additional_indicatorbenefits;
    }

    /**
     * Add otherlinks_indicatorbenefits
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorBenefit $otherlinksIndicatorbenefits
     * @return IndicatorReference
     */
    public function addOtherlinksIndicatorbenefit(\Yorku\JuturnaBundle\Entity\IndicatorBenefit $otherlinksIndicatorbenefits)
    {
        $this->otherlinks_indicatorbenefits[] = $otherlinksIndicatorbenefits;

        return $this;
    }

    /**
     * Remove otherlinks_indicatorbenefits
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorBenefit $otherlinksIndicatorbenefits
     */
    public function removeOtherlinksIndicatorbenefit(\Yorku\JuturnaBundle\Entity\IndicatorBenefit $otherlinksIndicatorbenefits)
    {
        $this->otherlinks_indicatorbenefits->removeElement($otherlinksIndicatorbenefits);
    }

    /**
     * Get otherlinks_indicatorbenefits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOtherlinksIndicatorbenefits()
    {
        return $this->otherlinks_indicatorbenefits;
    }
}
