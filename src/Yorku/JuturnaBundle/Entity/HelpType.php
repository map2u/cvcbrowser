<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HelpType
 */
class HelpType {

    /**
     * @var guid
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $seq;

    /**
     * @var boolean
     */
    private $enabled;

    /**
     * @var string
     */
    private $description;

    /**
     * Get id
     *
     * @return guid 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return HelpType
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
     * Set seq
     *
     * @param integer $seq
     * @return HelpType
     */
    public function setSeq($seq) {
        $this->seq = $seq;

        return $this;
    }

    /**
     * Get seq
     *
     * @return integer 
     */
    public function getSeq() {
        return $this->seq;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return HelpType
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled() {
        return $this->enabled;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return HelpType
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

    public function __toString() {
        return $this->name;
    }

}
