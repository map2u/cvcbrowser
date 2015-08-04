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
 * <summary>This is the definition of Category entity</summary>
 * <purpose></purpose>
 */

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 */
class Category {

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
     * @return Category 
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @return Category
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
    private $categorycontents;

    /**
     * Constructor
     */
    public function __construct() {
        $this->categorycontents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categorycontents
     *
     * @param \Yorku\JuturnaBundle\Entity\CategoryContents $categorycontents
     * @return Category
     */
    public function addCategorycontent(\Yorku\JuturnaBundle\Entity\CategoryContents $categorycontents) {
        $this->categorycontents[] = $categorycontents;

        return $this;
    }

    /**
     * Remove categorycontents
     *
     * @param \Yorku\JuturnaBundle\Entity\CategoryContents $categorycontents
     */
    public function removeCategorycontent(\Yorku\JuturnaBundle\Entity\CategoryContents $categorycontents) {
        $this->categorycontents->removeElement($categorycontents);
    }

    /**
     * Get categorycontents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategorycontents() {
        return $this->categorycontents;
    }

    /**
     * @var string
     */
    private $flashImages;

    /**
     * @var string
     */
    private $meaDiagram;

    /**
     * Set flashImages
     *
     * @param string $flashImages
     * @return Category
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
     * Set meaDiagram
     *
     * @param string $meaDiagram
     * @return Category
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
     * @return Category
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
