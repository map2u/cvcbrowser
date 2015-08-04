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
 * <summary>This is the definition of FeatureContents entity</summary>
 * <purpose></purpose>
 */

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeatureContents
 */
class FeatureContents {

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
    private $report;

    /**
     * @var string
     */
    private $reportLink;

    /**
     * @var integer
     */
    private $featureId;

    /**
     * @var string
     */
    private $layerType;

    /**
     * @var integer
     */
    private $layerId;

    /**
     * @var string
     */
    private $layerName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var array
     */
    private $tags;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

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
     * @param integer $id
     * @return FeatureContents 
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return FeatureContents
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
     * Set report
     *
     * @param string $report
     * @return FeatureContents
     */
    public function setReport($report) {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return string 
     */
    public function getReport() {
        return $this->report;
    }

    /**
     * Set reportLink
     *
     * @param string $reportLink
     * @return FeatureContents
     */
    public function setReportLink($reportLink) {
        $this->reportLink = $reportLink;

        return $this;
    }

    /**
     * Get reportLink
     *
     * @return string 
     */
    public function getReportLink() {
        return $this->reportLink;
    }

    /**
     * Set featureId
     *
     * @param integer $featureId
     * @return FeatureContents
     */
    public function setFeatureId($featureId) {
        $this->featureId = $featureId;

        return $this;
    }

    /**
     * Get featureId
     *
     * @return integer 
     */
    public function getFeatureId() {
        return $this->featureId;
    }

    /**
     * Set layerType
     *
     * @param string $layerType
     * @return FeatureContents
     */
    public function setLayerType($layerType) {
        $this->layerType = $layerType;

        return $this;
    }

    /**
     * Get layerType
     *
     * @return string 
     */
    public function getLayerType() {
        return $this->layerType;
    }

    /**
     * Set layerId
     *
     * @param integer $layerId
     * @return FeatureContents
     */
    public function setLayerId($layerId) {
        $this->layerId = $layerId;

        return $this;
    }

    /**
     * Get layerId
     *
     * @return integer 
     */
    public function getLayerId() {
        return $this->layerId;
    }

    /**
     * Set layerName
     *
     * @param string $layerName
     * @return FeatureContents
     */
    public function setLayerName($layerName) {
        $this->layerName = $layerName;

        return $this;
    }

    /**
     * Get layerName
     *
     * @return string 
     */
    public function getLayerName() {
        return $this->layerName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return FeatureContents
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
     * Set tags
     *
     * @param array $tags
     * @return FeatureContents
     */
    public function setTags($tags) {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return array 
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return FeatureContents
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
     * @return FeatureContents
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
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return FeatureContents
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getUser() {
        return $this->user;
    }

}
