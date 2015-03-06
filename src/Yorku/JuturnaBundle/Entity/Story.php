<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Story
 */
class Story {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $storyName;

    /**
     * @var string
     */
    private $summary;

    /**
     * @var string
     */
    private $type;

    /**
     * @var float
     */
    private $radius;

    /**
     * @var string
     */
    private $imageFile;

    /**
     * @var string
     */
    private $storyFile;

    /**
     * @var string
     */
    private $email;

    /**
     * @var geometry
     */
    private $theGeom;

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
     * @return integer 
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set storyName
     *
     * @param string $storyName
     * @return Story
     */
    public function setStoryName($storyName) {
        $this->storyName = $storyName;

        return $this;
    }

    /**
     * Get storyName
     *
     * @return string 
     */
    public function getStoryName() {
        return $this->storyName;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Story
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set radius
     *
     * @param string $radius
     * @return Story
     */
    public function setRadius($radius) {
        $this->radius = $radius;

        return $this;
    }

    /**
     * Get radius
     *
     * @return float 
     */
    public function getRadius() {
        return $this->radius;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Story
     */
    public function setSummary($summary) {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary() {
        return $this->summary;
    }

    /**
     * Set imageFile
     *
     * @param string $imageFile
     * @return Story
     */
    public function setImageFile($imageFile) {
        $this->imageFile = $imageFile;

        return $this;
    }

    /**
     * Get imageFile
     *
     * @return string 
     */
    public function getImageFile() {
        return $this->imageFile;
    }

    /**
     * Set storyFile
     *
     * @param string $storyFile
     * @return Story
     */
    public function setStoryFile($storyFile) {
        $this->storyFile = $storyFile;

        return $this;
    }

    /**
     * Get storyFile
     *
     * @return string 
     */
    public function getStoryFile() {
        return $this->storyFile;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Story
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set theGeom
     *
     * @param geometry $theGeom
     * @return Story
     */
    public function setTheGeom($theGeom) {
        $this->theGeom = $theGeom;

        return $this;
    }

    /**
     * Get theGeom
     *
     * @return geometry 
     */
    public function getTheGeom() {
        return $this->theGeom;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Story
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
     * @return Story
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
     * @return Story
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
