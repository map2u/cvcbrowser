<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Help
 */
class Help {

    /**
     * @var guid
     */
    private $id;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $zipFileName;

    /**
     * @var string
     */
    private $active;

    /**
     * @var string
     */
    private $fileType;

    /**
     * @var guid
     */
    private $helptypeId;

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
    private $content;

    /**
     * @var \Yorku\JuturnaBundle\Entity\HelpType
     */
    private $helpType;

    /**
     * Get id
     *
     * @return guid 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get helptypeId
     *
     * @return guid 
     */
    public function getHelptypeId() {
        return $this->helptypeId;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return Help
     */
    public function setFileName($fileName) {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * Set zipFileName
     *
     * @param string $zipFileName
     * @return Help
     */
    public function setZipFileName($zipFileName) {
        $this->zipFileName = $zipFileName;

        return $this;
    }

    /**
     * Get zipFileName
     *
     * @return string 
     */
    public function getZipFileName() {
        return $this->zipFileName;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Help
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
     * Set fileType
     *
     * @param string $fileType
     * @return Help
     */
    public function setFileType($fileType) {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * Get fileType
     *
     * @return string 
     */
    public function getFileType() {
        return $this->fileType;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Help
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
     * @return Help
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
     * Set content
     *
     * @param string $content
     * @return Help
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set helpType
     *
     * @param \Yorku\JuturnaBundle\Entity\HelpType $helpType
     * @return Help
     */
    public function setHelpType(\Yorku\JuturnaBundle\Entity\HelpType $helpType = null) {
        $this->helpType = $helpType;

        return $this;
    }

    /**
     * Get helpType
     *
     * @return \Yorku\JuturnaBundle\Entity\HelpType 
     */
    public function getHelpType() {
        return $this->helpType;
    }

}
