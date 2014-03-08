<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MemberShip
 */
class MemberShip
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bird_observations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $birds;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $species;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bird_observations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->birds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->species = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set id
     *  @param integer $id
     * @return MemberShip 
     */
    public function setId($id)
    {
        return $this->id=$id;
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return MemberShip
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get Name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }



    /**
     * @var string
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     * @return MemberShip
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;


    /**
     * Add users
     *
     * @param \Application\Sonata\UserBundle\Entity\User $users
     * @return MemberShip
     */
    public function addUser(\Application\Sonata\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Application\Sonata\UserBundle\Entity\User $users
     */
    public function removeUser(\Application\Sonata\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
    
    public function __toString()
    {
      return $this->name;
    }
}