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
 * <summary>This is the definition of CategoryContents entity</summary>
 * <purpose></purpose>
 */

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryContents
 */
class CategoryContents {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $detail;

    /**
     * @var integer
     */
    private $layerId;

    /**
     * @var string
     */
    private $citation;

    /**
     * @var string
     */
    private $citationLink;

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
     * @var \Yorku\JuturnaBundle\Entity\Category
     */
    private $category;

    /**
     * @var \Map2u\CoreBundle\Entity\UploadfileLayer
     */
    private $layer;

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
     * @return CategoryContents 
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return CategoryContents
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
     * Set detail
     *
     * @param string $detail
     * @return CategoryContents
     */
    public function setDetail($detail) {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string 
     */
    public function getDetail() {
        return $this->detail;
    }

    /**
     * Set layerId
     *
     * @param integer $layerId
     * @return CategoryContents
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
     * Set citation
     *
     * @param string $citation
     * @return CategoryContents
     */
    public function setCitation($citation) {
        $this->citation = $citation;

        return $this;
    }

    /**
     * Get citation
     *
     * @return string 
     */
    public function getCitation() {
        return $this->citation;
    }

    /**
     * Set citationLink
     *
     * @param string $citationLink
     * @return CategoryContents
     */
    public function setCitationLink($citationLink) {
        $this->citationLink = $citationLink;

        return $this;
    }

    /**
     * Get citationLink
     *
     * @return string 
     */
    public function getCitationLink() {
        return $this->citationLink;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return CategoryContents
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
     * @return CategoryContents
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
     * @return CategoryContents
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
     * @return CategoryContents
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
     * @return CategoryContents
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

    /**
     * Set category
     *
     * @param \Yorku\JuturnaBundle\Entity\Category $category
     * @return CategoryContents
     */
    public function setCategory(\Yorku\JuturnaBundle\Entity\Category $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Yorku\JuturnaBundle\Entity\Category 
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set layer
     *
     * @param \Map2u\CoreBundle\Entity\UploadfileLayer $layer
     * @return CategoryContents
     */
    public function setLayer(\Map2u\CoreBundle\Entity\UploadfileLayer $layer = null) {
        $this->layer = $layer;

        return $this;
    }

    /**
     * Get layer
     *
     * @return \Map2u\CoreBundle\Entity\UploadfileLayer 
     */
    public function getLayer() {
        return $this->layer;
    }

    /**
     * @var integer
     */
    private $position;

    /**
     * Set position
     *
     * @param integer $position
     * @return CategoryContents
     */
    public function setPosition($position) {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $contentdetails;

    /**
     * Constructor
     */
    public function __construct() {
        $this->contentdetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add contentdetails
     *
     * @param \Yorku\JuturnaBundle\Entity\CategoryContentDetails $contentdetails
     * @return CategoryContents
     */
    public function addContentdetail(\Yorku\JuturnaBundle\Entity\CategoryContentDetails $contentdetails) {
        $this->contentdetails[] = $contentdetails;

        return $this;
    }

    /**
     * Remove contentdetails
     *
     * @param \Yorku\JuturnaBundle\Entity\CategoryContentDetails $contentdetails
     */
    public function removeContentdetail(\Yorku\JuturnaBundle\Entity\CategoryContentDetails $contentdetails) {
        $this->contentdetails->removeElement($contentdetails);
    }

    /**
     * Get contentdetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContentdetails() {
        return $this->contentdetails;
    }

    /**
     * @var integer
     */
    private $categoryId;

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return CategoryContents
     */
    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId() {
        return $this->categoryId;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $displayLayers;

    /**
     * Add displayLayers
     *
     * @param \Map2u\CoreBundle\Entity\UploadfileLayer $displayLayers
     * @return CategoryContents
     */
    public function addDisplayLayer(\Map2u\CoreBundle\Entity\UploadfileLayer $displayLayers) {
        $this->displayLayers[] = $displayLayers;

        return $this;
    }

    /**
     * Remove displayLayers
     *
     * @param \Map2u\CoreBundle\Entity\UploadfileLayer $displayLayers
     */
    public function removeDisplayLayer(\Map2u\CoreBundle\Entity\UploadfileLayer $displayLayers) {
        $this->displayLayers->removeElement($displayLayers);
    }

    /**
     * Get displayLayers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDisplayLayers() {
        return $this->displayLayers;
    }

}
