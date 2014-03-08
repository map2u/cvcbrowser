<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TourismComments
 */
class TourismComments
{
    /**
     * @var integer
     */
    private $id;

   

    /**
     * @var string
     */
    private $code;

   
    /**
     * @var boolean
     */
    private $isPublished;

  
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
     * @var \Yorku\JuturnaBundle\Entity\Tourism
     */
    private $tourism;


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
     * Set code
     *
     * @param string $code
     * @return TourismComments
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    
    /**
     * Set isPublished
     *
     * @param boolean $isPublished
     * @return TourismComments
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    
        return $this;
    }

    /**
     * Get isPublished
     *
     * @return boolean 
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

  

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return TourismComments
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
     * @return TourismComments
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

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return TourismComments
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set tourism
     *
     * @param \Yorku\JuturnaBundle\Entity\Tourism $tourism
     * @return TourismComments
     */
    public function setTourism(\Yorku\JuturnaBundle\Entity\Tourism $tourism = null)
    {
        $this->tourism = $tourism;
    
        return $this;
    }

    /**
     * Get tourism
     *
     * @return \Yorku\JuturnaBundle\Entity\Tourism 
     */
    public function getTourism()
    {
        return $this->tourism;
    }
    
    
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $contentFormatter;

    /**
     * @var string
     */
    private $rawContent;

    /**
     * @var string
     */
    private $content;


    /**
     * Set title
     *
     * @param string $title
     * @return TourismComments
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set contentFormatter
     *
     * @param string $contentFormatter
     * @return TourismComments
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
    
        return $this;
    }

    /**
     * Get contentFormatter
     *
     * @return string 
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * Set rawContent
     *
     * @param string $rawContent
     * @return TourismComments
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;
    
        return $this;
    }

    /**
     * Get rawContent
     *
     * @return string 
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return TourismComments
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
}