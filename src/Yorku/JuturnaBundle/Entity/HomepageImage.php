<?php

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
     * @var \Yorku\JuturnaBundle\Entity\Category
     */
    private $category;

    /**
     * @var \Yorku\JuturnaBundle\Entity\Category
     */
    private $subcategory;

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
     * Set category
     *
     * @param \Yorku\JuturnaBundle\Entity\Category $category
     * @return HomepageImage
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
     * Set subcategory
     *
     * @param \Yorku\JuturnaBundle\Entity\Category $subcategory
     * @return HomepageImage
     */
    public function setSubcategory(\Yorku\JuturnaBundle\Entity\Category $subcategory = null) {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \Yorku\JuturnaBundle\Entity\Category 
     */
    public function getSubcategory() {
        return $this->subcategory;
    }

    public function __toString() {
        return $this->title;
    }

}
