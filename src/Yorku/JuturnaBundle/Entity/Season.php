<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Season
 */
class Season
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $seasonName;

    /**
     * @var string
     */
    private $code;


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
     * Set seasonName
     *
     * @param string $seasonName
     * @return Season
     */
    public function setSeasonName($seasonName)
    {
        $this->seasonName = $seasonName;
    
        return $this;
    }

    /**
     * Get seasonName
     *
     * @return string 
     */
    public function getSeasonName()
    {
        return $this->seasonName;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Season
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
    
     public function __toString()
    {
      return $this->seasonName;
    }    
}
