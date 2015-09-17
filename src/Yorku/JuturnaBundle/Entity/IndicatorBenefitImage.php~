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
 * <summary>This is the definition of IndicatorBenefitImage entity</summary>
 * <purpose></purpose>
 */

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IndicatorBenefitImage
 */
class IndicatorBenefitImage {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $imageName;

    /**
     * @var string
     */
    private $imageTitle;

    /**
     * @var string
     */
    private $imageCaption;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

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
     * Set imageName
     *
     * @param string $imageName
     * @return IndicatorBenefitImage
     */
    public function setImageName($imageName) {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName() {
        return $this->imageName;
    }

    /**
     * Set imageTitle
     *
     * @param string $imageTitle
     * @return IndicatorBenefitImage
     */
    public function setImageTitle($imageTitle) {
        $this->imageTitle = $imageTitle;

        return $this;
    }

    /**
     * Get imageTitle
     *
     * @return string 
     */
    public function getImageTitle() {
        return $this->imageTitle;
    }

    /**
     * Set imageCaption
     *
     * @param string $imageCaption
     * @return IndicatorBenefitImage
     */
    public function setImageCaption($imageCaption) {
        $this->imageCaption = $imageCaption;

        return $this;
    }

    /**
     * Get imageCaption
     *
     * @return string 
     */
    public function getImageCaption() {
        return $this->imageCaption;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return IndicatorBenefitImage
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
     * @return IndicatorBenefitImage
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
     * Add indicatorbenefits
     *
     * @param \Yorku\JuturnaBundle\Entity\IndicatorBenefit $indicatorbenefits
     * @return IndicatorBenefitImage
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
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $description;

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return IndicatorBenefitImage
     */
    public function setFileName($fileName) {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return IndicatorBenefitImage
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @var \Yorku\JuturnaBundle\Entity\Indicator
     */
    private $indicator;

    /**
     * Set indicator
     *
     * @param \Yorku\JuturnaBundle\Entity\Indicator $indicator
     * @return IndicatorBenefitImage
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

}
