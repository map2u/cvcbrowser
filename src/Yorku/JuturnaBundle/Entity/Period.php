<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Period
 */
class Period
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $periodName;

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
     * Set periodName
     *
     * @param string $periodName
     * @return Period
     */
    public function setPeriodName($periodName)
    {
        $this->periodName = $periodName;
    
        return $this;
    }

    /**
     * Get periodName
     *
     * @return string 
     */
    public function getPeriodName()
    {
        return $this->periodName;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Period
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
}
