<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IUCN
 */
class IUCN
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $IUCNName;

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
     * Set IUCNName
     *
     * @param string $iUCNName
     * @return IUCN
     */
    public function setIUCNName($iUCNName)
    {
        $this->IUCNName = $iUCNName;
    
        return $this;
    }

    /**
     * Get IUCNName
     *
     * @return string 
     */
    public function getIUCNName()
    {
        return $this->IUCNName;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return IUCN
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
      return $this->IUCNName;
    }    
}
