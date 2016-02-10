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
 * <summary>This is the definition of IndicatorBenefit entity</summary>
 * <purpose></purpose>
 */

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IndicatorBenefit
 */
class IndicatorBenefit {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $benefitName;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $abstract;

    /**
     * @var string
     */
    private $briefReport;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Yorku\JuturnaBundle\Entity\Indicator
     */
    private $indicator;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ecosystemservices;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $humanwellbeingedomains;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorreferences;

    /**
     * Constructor
     */
    public function __construct() {
        $this->ecosystemservices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->humanwellbeingedomains = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorreferences = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set benefitName
     *
     * @param string $benefitName
     * @return IndicatorBenefit
     */
    public function setBenefitName($benefitName) {
        $this->benefitName = $benefitName;

        return $this;
    }

    /**
     * Get benefitName
     *
     * @return string 
     */
    public function getBenefitName() {
        return $this->benefitName;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return IndicatorBenefit
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set abstract
     *
     * @param string $abstract
     * @return IndicatorBenefit
     */
    public function setAbstract($abstract) {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * Get abstract
     *
     * @return string 
     */
    public function getAbstract() {
        return $this->abstract;
    }

    /**
     * Set briefReport
     *
     * @param string $briefReport
     * @return IndicatorBenefit
     */
    public function setBriefReport($briefReport) {
        $this->briefReport = $briefReport;

        return $this;
    }

    /**
     * Get briefReport
     *
     * @return string 
     */
    public function getBriefReport() {
        return $this->briefReport;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return IndicatorBenefit
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return IndicatorBenefit
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set indicator
     *
     * @param \Yorku\JuturnaBundle\Entity\Indicator $indicator
     * @return IndicatorBenefit
     */
    public function setIndicator(\Yorku\JuturnaBundle\Entity\Indicator $indicator = null) {
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return \Yorku\JuturnaBundle\Entity\Indicator 
     */
    public function getIndicator() {
        return $this->indicator;
    }

    /**
     * Add ecosystemservices
     *
     * @param \Yorku\JuturnaBundle\Entity\EcoSystemService $ecosystemservices
     * @return IndicatorBenefit
     */
    public function addEcosystemservice(\Yorku\JuturnaBundle\Entity\EcoSystemService $ecosystemservices) {
        $this->ecosystemservices[] = $ecosystemservices;

        return $this;
    }

    /**
     * Remove ecosystemservices
     *
     * @param \Yorku\JuturnaBundle\Entity\EcoSystemService $ecosystemservices
     */
    public function removeEcosystemservice(\Yorku\JuturnaBundle\Entity\EcoSystemService $ecosystemservices) {
        $this->ecosystemservices->removeElement($ecosystemservices);
    }

    /**
     * Get ecosystemservices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEcosystemservices() {
        return $this->ecosystemservices;
    }

    /**
     * Add humanwellbeingedomains
     *
     * @param \Yorku\JuturnaBundle\Entity\HumanWellBeingDomain $humanwellbeingedomains
     * @return IndicatorBenefit
     */
    public function addHumanwellbeingedomain(\Yorku\JuturnaBundle\Entity\HumanWellBeingDomain $humanwellbeingedomains) {
        $this->humanwellbeingedomains[] = $humanwellbeingedomains;

        return $this;
    }

    /**
     * Remove humanwellbeingedomains
     *
     * @param \Yorku\JuturnaBundle\Entity\HumanWellBeingDomain $humanwellbeingedomains
     */
    public function removeHumanwellbeingedomain(\Yorku\JuturnaBundle\Entity\HumanWellBeingDomain $humanwellbeingedomains) {
        $this->humanwellbeingedomains->removeElement($humanwellbeingedomains);
    }

    /**
     * Get humanwellbeingedomains
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHumanwellbeingedomains() {
        return $this->humanwellbeingedomains;
    }

    /**
     * Add indicatorreferences
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorReference $indicatorreferences
     * @return IndicatorBenefit
     */
    public function addIndicatorreference(\Yorku\JuturnaBundle\Entity\IndicatorReference $indicatorreferences) {
        $this->indicatorreferences[] = $indicatorreferences;

        return $this;
    }

    /**
     * Remove indicatorreferences
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorReference $indicatorreferences
     */
    public function removeIndicatorreference(\Yorku\JuturnaBundle\Entity\IndicatorReference $indicatorreferences) {
        $this->indicatorreferences->removeElement($indicatorreferences);
    }

    /**
     * Get indicatorreferences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicatorreferences() {
        return $this->indicatorreferences;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorbenefitimages;

    /**
     * Add indicatorbenefitimages
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorBenefitImage $indicatorbenefitimages
     * @return IndicatorBenefit
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
        return $this->benefitName;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $symbolizedLayers;

    /**
     * Add symbolizedLayers
     *
     * @param \Map2u\CoreBundle\Entity\SymbolizedLayer $symbolizedLayers
     * @return IndicatorBenefit
     */
    public function addSymbolizedLayer(\Map2u\CoreBundle\Entity\SymbolizedLayer $symbolizedLayers) {
        $this->symbolizedLayers[] = $symbolizedLayers;

        return $this;
    }

    /**
     * Remove symbolizedLayers
     *
     * @param \Map2u\CoreBundle\Entity\SymbolizedLayer $symbolizedLayers
     */
    public function removeSymbolizedLayer(\Map2u\CoreBundle\Entity\SymbolizedLayer $symbolizedLayers) {
        $this->symbolizedLayers->removeElement($symbolizedLayers);
    }

    /**
     * Get symbolizedLayers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSymbolizedLayers() {
        return $this->symbolizedLayers;
    }

    

   
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $additionalreferences;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $otherlinks;

    /**
     * Add additionalreferences
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorReference $additionalreferences
     * @return IndicatorBenefit
     */
    public function addAdditionalreference(\Yorku\JuturnaBundle\Entity\IndicatorReference $additionalreferences) {
        $this->additionalreferences[] = $additionalreferences;

        return $this;
    }

    /**
     * Remove additionalreferences
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorReference $additionalreferences
     */
    public function removeAdditionalreference(\Yorku\JuturnaBundle\Entity\IndicatorReference $additionalreferences) {
        $this->additionalreferences->removeElement($additionalreferences);
    }

    /**
     * Get additionalreferences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdditionalreferences() {
        return $this->additionalreferences;
    }

    /**
     * Add otherlinks
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorReference $otherlinks
     * @return IndicatorBenefit
     */
    public function addOtherlink(\Yorku\JuturnaBundle\Entity\IndicatorReference $otherlinks) {
        $this->otherlinks[] = $otherlinks;

        return $this;
    }

    /**
     * Remove otherlinks
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorReference $otherlinks
     */
    public function removeOtherlink(\Yorku\JuturnaBundle\Entity\IndicatorReference $otherlinks) {
        $this->otherlinks->removeElement($otherlinks);
    }

    /**
     * Get otherlinks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOtherlinks() {
        return $this->otherlinks;
    }

}
