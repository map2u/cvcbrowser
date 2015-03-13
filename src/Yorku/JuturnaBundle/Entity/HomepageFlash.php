<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HomepageFlash
 */
class HomepageFlash {

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
    private $introduce;

    /**
     * @var string
     */
    private $image;

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
     * Set id
     * @param integer $id
     * @return HomepageFlash 
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return HomepageFlash
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
     * Set introduce
     *
     * @param string $introduce
     * @return HomepageFlash
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
     * Set image
     *
     * @param string $image
     * @return HomepageFlash
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
     * Set url
     *
     * @param string $url
     * @return HomepageFlash
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
     * @return HomepageFlash
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
     * @return HomepageFlash
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
     * @return HomepageFlash
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
     * @return HomepageFlash
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
     * @return HomepageFlash
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
     * @return HomepageFlash
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
     * @return HomepageFlash
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

    /**
     * @var integer
     */
    private $titleMargin;

    /**
     * @var boolean
     */
    private $alignLeft;


    /**
     * Set titleMargin
     *
     * @param integer $titleMargin
     * @return HomepageFlash
     */
    public function setTitleMargin($titleMargin)
    {
        $this->titleMargin = $titleMargin;

        return $this;
    }

    /**
     * Get titleMargin
     *
     * @return integer 
     */
    public function getTitleMargin()
    {
        return $this->titleMargin;
    }

    /**
     * Set alignLeft
     *
     * @param boolean $alignLeft
     * @return HomepageFlash
     */
    public function setAlignLeft($alignLeft)
    {
        $this->alignLeft = $alignLeft;

        return $this;
    }

    /**
     * Get alignLeft
     *
     * @return boolean 
     */
    public function getAlignLeft()
    {
        return $this->alignLeft;
    }
}
