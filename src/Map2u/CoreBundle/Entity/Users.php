<?php

namespace Map2u\CoreBundle\Entity;
use FOS\UserBundle\Entity\Group as BaseGroup;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\GroupableInterface;
/**
 * Users
 */
class Users extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Yorku\AbmBundle\Entity\Datasets", mappedBy="datasets")
   */  
    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

  

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct(){
        parent::__construct();
        $this->enterprise= new \Doctrine\Common\Collections\ArrayCollection();
    }  
    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Users
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Users
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

   
   
}
