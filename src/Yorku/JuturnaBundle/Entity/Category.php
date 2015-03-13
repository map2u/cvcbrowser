<?php

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
    public function __construct()
    {
        $this->categorycontents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categorycontents
     *
     * @param \Yorku\JuturnaBundle\Entity\CategoryContents $categorycontents
     * @return Category
     */
    public function addCategorycontent(\Yorku\JuturnaBundle\Entity\CategoryContents $categorycontents)
    {
        $this->categorycontents[] = $categorycontents;

        return $this;
    }

    /**
     * Remove categorycontents
     *
     * @param \Yorku\JuturnaBundle\Entity\CategoryContents $categorycontents
     */
    public function removeCategorycontent(\Yorku\JuturnaBundle\Entity\CategoryContents $categorycontents)
    {
        $this->categorycontents->removeElement($categorycontents);
    }

    /**
     * Get categorycontents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategorycontents()
    {
        return $this->categorycontents;
    }
}
