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
 * <summary>This is the extend of Sonata\ClassificationBundle\Entity\BaseTag entity</summary>
 * <purpose>for entity extend based on Sonata\ClassificationBundle\Entity\BaseTag</purpose>

 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.

 */

namespace Application\Sonata\ClassificationBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseTag;

/**
 * Tag
 */
class Tag extends BaseTag {

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $graphcharts;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->graphcharts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Add graphcharts
     *
     * @param \Yorku\JuturnaBundle\Entity\GraphChart $graphcharts
     * @return Tag
     */
    public function addGraphchart(\Yorku\JuturnaBundle\Entity\GraphChart $graphcharts) {
        $this->graphcharts[] = $graphcharts;

        return $this;
    }

    /**
     * Remove graphcharts
     *
     * @param \Yorku\JuturnaBundle\Entity\GraphChart $graphcharts
     */
    public function removeGraphchart(\Yorku\JuturnaBundle\Entity\GraphChart $graphcharts) {
        $this->graphcharts->removeElement($graphcharts);
    }

    /**
     * Get graphcharts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGraphcharts() {
        return $this->graphcharts;
    }

}
