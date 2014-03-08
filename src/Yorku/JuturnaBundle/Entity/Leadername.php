<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Leadername
 *
 * @ORM\Table(name="leadername")
 * @ORM\Entity
 */
class Leadername
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="leadername_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="leadername", type="string", nullable=true)
     */
    private $leadername;



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
     * Set leadername
     *
     * @param string $leadername
     * @return Leadername
     */
    public function setLeadername($leadername)
    {
        $this->leadername = $leadername;
    
        return $this;
    }

    /**
     * Get leadername
     *
     * @return string 
     */
    public function getLeadername()
    {
        return $this->leadername;
    }
}