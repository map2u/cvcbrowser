<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 */
class Groups
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $leaderName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     * @return Groups
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
     * Set leaderName
     *
     * @param string $leaderName
     * @return Groups
     */
    public function setLeaderName($leaderName)
    {
        $this->leaderName = $leaderName;
    
        return $this;
    }

    /**
     * Get leaderName
     *
     * @return string 
     */
    public function getLeaderName()
    {
        return $this->leaderName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Groups
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}