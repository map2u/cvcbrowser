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
 * <summary>This is the definition of ContentCategory entity</summary>
 * <purpose></purpose>
 */

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContentCategory
 */
class ContentCategory {

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
    private $slug;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $rightColumn;

    /**
     * @var integer
     */
    private $rightColumnWidth;

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
     * @return ContentCategory 
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ContentCategory
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
     * Set rightColumn
     *
     * @param string $rightColumn
     * @return ContentCategory
     */
    public function setRightColumn($rightColumn) {
        $this->rightColumn = $rightColumn;

        return $this;
    }

    /**
     * Get rightColumn
     *
     * @return string 
     */
    public function getRightColumn() {
        return $this->rightColumn;
    }

    /**
     * Set rightColumnWidth
     *
     * @param integer $rightColumnWidth
     * @return ContentCategory
     */
    public function setRightColumnWidth($rightColumnWidth) {
        $this->rightColumnWidth = $rightColumnWidth;

        return $this;
    }

    /**
     * Get rightColumnWidth
     *
     * @return integer 
     */
    public function getRightColumnWidth() {
        return $this->rightColumnWidth;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return ContentCategory
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ContentCategory
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
     * @return ContentCategory
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
     * @return ContentCategory
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
     * @return ContentCategory
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

    public function __toString() {
        return $this->name;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $contents;

    /**
     * Constructor
     */
    public function __construct() {
        $this->contents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add contents
     *
     * @param \Yorku\JuturnaBundle\Entity\Content $contents
     * @return Category
     */
    public function addContent(\Yorku\JuturnaBundle\Entity\Content $contents) {
        $this->contents[] = $contents;

        return $this;
    }

    /**
     * Remove contents
     *
     * @param \Yorku\JuturnaBundle\Entity\Content $contents
     */
    public function removeContent(\Yorku\JuturnaBundle\Entity\Content $contents) {
        $this->contents->removeElement($contents);
    }

    /**
     * Get contents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContents() {
        return $this->contents;
    }

    /**
     * @var string
     */
    private $flashImages;

    /**
     * @var string
     */
    private $altText;

    /**
     * @var string
     */
    private $meaDiagram;

    /**
     * Set flashImages
     *
     * @param string $flashImages
     * @return ContentCategory
     */
    public function setFlashImages($flashImages) {
        $this->flashImages = $flashImages;

        return $this;
    }

    /**
     * Get flashImages
     *
     * @return string 
     */
    public function getFlashImages() {
        return $this->flashImages;
    }

    /**
     * Set altText
     *
     * @param string $altText
     * @return ContentCategory
     */
    public function setAltText($altText) {
        $this->altText = $altText;
        return $this;
    }

    /**
     * Get altText
     *
     * @return string 
     */
    public function getAltText() {
        return $this->altText;
    }

    /**
     * Set meaDiagram
     *
     * @param string $meaDiagram
     * @return ContentCategory
     */
    public function setMeaDiagram($meaDiagram) {
        $this->meaDiagram = $meaDiagram;

        return $this;
    }

    /**
     * Get meaDiagram
     *
     * @return string 
     */
    public function getMeaDiagram() {
        return $this->meaDiagram;
    }

    /**
     * @var string
     */
    private $title;

    /**
     * Set title
     *
     * @param string $title
     * @return ContentCategory
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

}
