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
 * <summary>This is the definition of TempPolygon entity</summary>
 * <purpose></purpose>
 */

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TempPolygon
 *
 * @ORM\Table(name="temp_polygon")
 * @ORM\Entity
 */
class TempPolygon {

    /**
     * @var integer
     *
     * @ORM\Column(name="gid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="temp_polygon_gid_seq", allocationSize=1, initialValue=1)
     */
    private $gid;

    /**
     * @var string
     *
     * @ORM\Column(name="watershed_name", type="string", length=50, nullable=true)
     */
    private $watershedName;

    /**
     * @var string
     *
     * @ORM\Column(name="subwatershed_name", type="string", length=50, nullable=true)
     */
    private $subwatershedName;

    /**
     * @var geometry
     *
     * @ORM\Column(name="the_geom", type="geometry", nullable=true)
     */
    private $theGeom;

    /**
     * Get gid
     *
     * @return integer 
     */
    public function getGid() {
        return $this->gid;
    }

    /**
     * Set watershedName
     *
     * @param string $watershedName
     * @return TempPolygon
     */
    public function setWatershedName($watershedName) {
        $this->watershedName = $watershedName;

        return $this;
    }

    /**
     * Get watershedName
     *
     * @return string 
     */
    public function getWatershedName() {
        return $this->watershedName;
    }

    /**
     * Set subwatershedName
     *
     * @param string $subwatershedName
     * @return TempPolygon
     */
    public function setSubwatershedName($subwatershedName) {
        $this->subwatershedName = $subwatershedName;

        return $this;
    }

    /**
     * Get subwatershedName
     *
     * @return string 
     */
    public function getSubwatershedName() {
        return $this->subwatershedName;
    }

    /**
     * Set theGeom
     *
     * @param geometry $theGeom
     * @return TempPolygon
     */
    public function setTheGeom($theGeom) {
        $this->theGeom = $theGeom;

        return $this;
    }

    /**
     * Get theGeom
     *
     * @return geometry 
     */
    public function getTheGeom() {
        return $this->theGeom;
    }

}
