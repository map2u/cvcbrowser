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
 * <summary>This is the definition of HomepageImage entity</summary>
 * <purpose></purpose>
 */

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HomepageImage
 */
class HomepageImage {

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
    private $image;

    /**
     * @var string
     */
    private $introduce;

    /**
     * @var string
     */
    private $url;

    /**
     * @var boolean
     */
    private $published;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Yorku\JuturnaBundle\Entity\ContentCategory
     */
    private $contentCategory;

    /**
     * @var \Yorku\JuturnaBundle\Entity\ContentCategory
     */
    private $contentSubcategory;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return HomepageImage
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Set id
     * @param integer $id
     * @return HomepageImage 
     */
    public function setId($id) {
        $this->id = $id;
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
     * Set image
     *
     * @param string $image
     * @return HomepageImage
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set introduce
     *
     * @param string $introduce
     * @return HomepageImage
     */
    public function setIntroduce($introduce) {
        $this->introduce = $introduce;

        return $this;
    }

    /**
     * Get introduce
     *
     * @return string 
     */
    public function getIntroduce() {
        return $this->introduce;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return HomepageImage
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return HomepageImage
     */
    public function setPublished($published) {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished() {
        return $this->published;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return HomepageImage
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return HomepageImage
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
     * @return HomepageImage
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
     * Set description
     *
     * @param string $description
     * @return HomepageImage
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
     * Set contentCategory
     *
     * @param \Yorku\JuturnaBundle\Entity\ContentCategory $contentCategory
     * @return HomepageImage
     */
    public function setContentCategory(\Yorku\JuturnaBundle\Entity\ContentCategory $contentCategory = null) {
        $this->contentCategory = $contentCategory;

        return $this;
    }

    /**
     * Get contentCategory
     *
     * @return \Yorku\JuturnaBundle\Entity\ContentCategory 
     */
    public function getContentCategory() {
        return $this->contentCategory;
    }

    /**
     * Set contentSubcategory
     *
     * @param \Yorku\JuturnaBundle\Entity\ContentCategory $contentSubcategory
     * @return HomepageImage
     */
    public function setContentSubcategory(\Yorku\JuturnaBundle\Entity\ContentCategory $contentSubcategory = null) {
        $this->contentSubcategory = $contentSubcategory;

        return $this;
    }

    /**
     * Get contentSubcategory
     *
     * @return \Yorku\JuturnaBundle\Entity\ContentCategory 
     */
    public function getContentSubcategory() {
        return $this->contentSubcategory;
    }

    public function __toString() {
        return $this->title;
    }

    /**
     * @var string
     */
    private $altText;


    /**
     * Set altText
     *
     * @param string $altText
     * @return HomepageImage
     */
    public function setAltText($altText)
    {
        $this->altText = $altText;

        return $this;
    }

    /**
     * Get altText
     *
     * @return string 
     */
    public function getAltText()
    {
        return $this->altText;
    }
}
