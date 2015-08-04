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
 * <summary>This is the definition of CategoryContentDetails entity</summary>
 * <purpose></purpose>
 */

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryContentDetails
 */
class CategoryContentDetails {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $detail;

    /**
     * @var integer
     */
    private $position;

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
     * @var \Yorku\JuturnaBundle\Entity\CategoryContents
     */
    private $categorycontent;

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
     * @return CategoryContentDetails 
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set detail
     *
     * @param string $detail
     * @return CategoryContentDetails
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
     * Set position
     *
     * @param integer $position
     * @return CategoryContentDetails
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
     * Set citation
     *
     * @param string $citation
     * @return CategoryContentDetails
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
     * @return CategoryContentDetails
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
     * @return CategoryContentDetails
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
     * @return CategoryContentDetails
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
     * @return CategoryContentDetails
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
     * @return CategoryContentDetails
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
     * Set categorycontent
     *
     * @param \Yorku\JuturnaBundle\Entity\CategoryContents $categorycontent
     * @return CategoryContentDetails
     */
    public function setCategorycontent(\Yorku\JuturnaBundle\Entity\CategoryContents $categorycontent = null) {
        $this->categorycontent = $categorycontent;

        return $this;
    }

    /**
     * Get categorycontent
     *
     * @return \Yorku\JuturnaBundle\Entity\CategoryContents 
     */
    public function getCategorycontent() {
        return $this->categorycontent;
    }

}
