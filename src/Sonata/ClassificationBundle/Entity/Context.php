<?php

/**
 * <copyright>
 * This file/program is free and open source software released under the GNU General Public
 * License version 3, and is distributed WITHOUT ANY WARRANTY. A copy of the GNU General
 * Public Licence is available at http://www.gnu.org/licenses
 * </copyright>
 *
 * <author>Shuilin (Joseph) Zhao</author>
 * <company>SpEAR Lab, Faculty of Environmental Studies, York University
 * <email>zhaoshuilin2004@yahoo.ca</email>
 * <date>created at 2014/01/06</date>
 * <date>last updated at 2015/03/11</date>
 * <summary>This is the extend of Sonata\ClassificationBundle\Entity\BaseContext entity</summary>
 * <purpose>for entity extend based on Sonata\ClassificationBundle\Entity\BaseContext</purpose>
 */

namespace Application\Sonata\ClassificationBundle\Entity;

use Sonata\ClassificationBundle\Entity\BaseContext;
use Doctrine\ORM\Mapping as ORM;

/**
 * Context
 */
class Context extends BaseContext {

    /**
     * @var string
     */
    protected $id;

    /**
     * Set id
     *
     * @param string $id
     * @return Context
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId() {
        return $this->id;
    }

}
