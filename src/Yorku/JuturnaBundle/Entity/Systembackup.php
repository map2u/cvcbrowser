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
 * <summary>This is the definition of Systembackup entity</summary>
 * <purpose></purpose>
 */

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Systembackup
 */
class Systembackup {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $foldername;

    /**
     * @var \DateTime
     */
    private $backupAt;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \DateTime
     */
    private $finishedAt;

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
     * Set filename
     *
     * @param string $filename
     * @return Systembackup
     */
    public function setFilename($filename) {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * Set foldername
     *
     * @param string $foldername
     * @return Systembackup
     */
    public function setFoldername($foldername) {
        $this->foldername = $foldername;

        return $this;
    }

    /**
     * Get foldername
     *
     * @return string 
     */
    public function getFoldername() {
        return $this->foldername;
    }

    /**
     * Set backupAt
     *
     * @param \DateTime $backupAt
     * @return Systembackup
     */
    public function setBackupAt($backupAt) {
        $this->backupAt = $backupAt;

        return $this;
    }

    /**
     * Get backupAt
     *
     * @return \DateTime 
     */
    public function getBackupAt() {
        return $this->backupAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Systembackup
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
     * @return Systembackup
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
     * Set finishedAt
     *
     * @param \DateTime $finishedAt
     * @return Systembackup
     */
    public function setFinishedAt($finishedAt) {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    /**
     * Get finishedAt
     *
     * @return \DateTime 
     */
    public function getFinishedAt() {
        return $this->finishedAt;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return Systembackup
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
