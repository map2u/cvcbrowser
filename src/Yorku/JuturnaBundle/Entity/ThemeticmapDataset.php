<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThemeticmapDataset
 */
class ThemeticmapDataset
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $useruploadfileId;

    /**
     * @var string
     */
    private $keyField;

    /**
     * @var string
     */
    private $valueField;

    /**
     * @var string
     */
    private $type;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return ThemeticmapDataset
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ThemeticmapDataset
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set useruploadfileId
     *
     * @param integer $useruploadfileId
     * @return ThemeticmapDataset
     */
    public function setUseruploadfileId($useruploadfileId)
    {
        $this->useruploadfileId = $useruploadfileId;

        return $this;
    }

    /**
     * Get useruploadfileId
     *
     * @return integer 
     */
    public function getUseruploadfileId()
    {
        return $this->useruploadfileId;
    }

    /**
     * Set keyField
     *
     * @param string $keyField
     * @return ThemeticmapDataset
     */
    public function setKeyField($keyField)
    {
        $this->keyField = $keyField;

        return $this;
    }

    /**
     * Get keyField
     *
     * @return string 
     */
    public function getKeyField()
    {
        return $this->keyField;
    }

    /**
     * Set valueField
     *
     * @param string $valueField
     * @return ThemeticmapDataset
     */
    public function setValueField($valueField)
    {
        $this->valueField = $valueField;

        return $this;
    }

    /**
     * Get valueField
     *
     * @return string 
     */
    public function getValueField()
    {
        return $this->valueField;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return ThemeticmapDataset
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ThemeticmapDataset
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return ThemeticmapDataset
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
