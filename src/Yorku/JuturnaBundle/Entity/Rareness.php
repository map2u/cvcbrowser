<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rareness
 */
class Rareness
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $rarenessName;

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
     * Set rarenessName
     *
     * @param string $rarenessName
     * @return Rareness
     */
    public function setRarenessName($rarenessName)
    {
        $this->rarenessName = $rarenessName;
    
        return $this;
    }

    /**
     * Get rarenessName
     *
     * @return string 
     */
    public function getRarenessName()
    {
        return $this->rarenessName;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Rareness
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
      return $this->rarenessName;
    }    
}
