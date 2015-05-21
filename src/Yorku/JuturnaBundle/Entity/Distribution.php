<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Distribution
 */
class Distribution
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $distributionName;

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
     * Set distributionName
     *
     * @param string $distributionName
     * @return Distribution
     */
    public function setDistributionName($distributionName)
    {
        $this->distributionName = $distributionName;
    
        return $this;
    }

    /**
     * Get distributionName
     *
     * @return string 
     */
    public function getDistributionName()
    {
        return $this->distributionName;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Distribution
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
      return $this->distributionName;
    }    
}
