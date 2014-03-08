<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PeriodStatus
 */
class PeriodStatus
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $statusName;

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
     * Set statusName
     *
     * @param string $statusName
     * @return PeriodStatus
     */
    public function setStatusName($statusName)
    {
        $this->statusName = $statusName;
    
        return $this;
    }

    /**
     * Get statusName
     *
     * @return string 
     */
    public function getStatusName()
    {
        return $this->statusName;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return PeriodStatus
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