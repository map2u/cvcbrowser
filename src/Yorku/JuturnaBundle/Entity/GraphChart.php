<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GraphChart
 */
class GraphChart {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $category;

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
    private $graphchartName;

    /**
     * @var string
     */
    private $graphchartTitle;

    /**
     * @var string
     */
    private $graphchartImages;

    /**
     * @var string
     */
    private $tags;

    /**
     * @var string
     */
    private $description;

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
     * @return GraphChart 
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return GraphChart
     */
    public function setCategory($category) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set citation
     *
     * @param string $citation
     * @return GraphChart
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
     * @return GraphChart
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
     * Set graphchartName
     *
     * @param string $graphchartName
     * @return GraphChart
     */
    public function setGraphchartName($graphchartName) {
        $this->graphchartName = $graphchartName;

        return $this;
    }

    /**
     * Get graphchartName
     *
     * @return string 
     */
    public function getGraphchartName() {
        return $this->graphchartName;
    }

    /**
     * Set graphchartTitle
     *
     * @param string $graphchartTitle
     * @return GraphChart
     */
    public function setGraphchartTitle($graphchartTitle) {
        $this->graphchartTitle = $graphchartTitle;

        return $this;
    }

    /**
     * Get graphchartTitle
     *
     * @return string 
     */
    public function getGraphchartTitle() {
        return $this->graphchartTitle;
    }

    /**
     * Set graphchartImages
     *
     * @param string $graphchartImages
     * @return GraphChart
     */
    public function setGraphchartImages($graphchartImages) {
        $this->graphchartImages = $graphchartImages;

        return $this;
    }

    /**
     * Get graphchartImages
     *
     * @return string 
     */
    public function getGraphchartImages() {
        return $this->graphchartImages;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return GraphChart
     */
    public function setTags($tags) {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return GraphChart
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return GraphChart
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
     * @return GraphChart
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
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return GraphChart
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
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tags
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Tag $tags
     * @return GraphChart
     */
    public function addTag(\Application\Sonata\ClassificationBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Tag $tags
     */
    public function removeTag(\Application\Sonata\ClassificationBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;


    /**
     * Add categories
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $categories
     * @return GraphChart
     */
    public function addCategory(\Application\Sonata\ClassificationBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $categories
     */
    public function removeCategory(\Application\Sonata\ClassificationBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
