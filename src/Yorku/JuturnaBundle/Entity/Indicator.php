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
 * <summary>This is the definition of Indicator entity</summary>
 * <purpose></purpose>
 */

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
