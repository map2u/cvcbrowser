<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Family
 */
class Family
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $familyName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $birds;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->birds = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set familyName
     *
     * @param string $familyName
     * @return Family
     */
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;
    
        return $this;
    }

    /**
     * Get familyName
     *
     * @return string 
     */
    public function getFamilyName()
    {
        return $this->familyName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Family
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
     * Add birds
     *
     * @param \Yorku\JuturnaBundle\Entity\Bird $birds
     * @return Family
     */
    public function addBird(\Yorku\JuturnaBundle\Entity\Bird $birds)
    {
        $this->birds[] = $birds;
    
        return $this;
    }

    /**
     * Remove birds
     *
     * @param \Yorku\JuturnaBundle\Entity\Bird $birds
     */
    public function removeBird(\Yorku\JuturnaBundle\Entity\Bird $birds)
    {
        $this->birds->removeElement($birds);
    }

    /**
     * Get birds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBirds()
    {
        return $this->birds;
    }
}
