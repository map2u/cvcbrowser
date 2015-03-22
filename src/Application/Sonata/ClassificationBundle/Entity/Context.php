<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Sonata\ClassificationBundle\Entity\BaseContext;

use Doctrine\ORM\Mapping as ORM;

/**
 * Context
 */
class Context extends BaseContext
{
    /**
     * @var string
     */
    private $id;


    /**
     * Set id
     *
     * @param string $id
     * @return Context
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
}
