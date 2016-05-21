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
 * <summary>This file is extend of Twig_Extension</summary>
 * <purpose>based on Twig_Extension to extend more methods</purpose>
 */
// src/Map2u/WebgisBundle/Twig/Map2uExtension.php

namespace Application\Map2u\CoreBundle\Twig;

class Map2uExtension extends \Twig_Extension {

    public function getFilters() {
        return array(
            'imgpath' => new \Twig_Filter_Method($this, 'imgpathFilter'),
            'bcmod' => new \Twig_Filter_Method($this, 'bcmodFilter'),
            'bcdiv' => new \Twig_Filter_Method($this, 'bcdivFilter'),
            'price' => new \Twig_Filter_Method($this, 'priceFilter'),
            'json_decode' => new \Twig_Filter_Method($this, 'jsonDecode'),
            'unserialize' => new \Twig_Filter_Method($this, 'unserializeFilter'),
        );
    }

    public function jsonDecode($str) {
        return json_decode($str);
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',') {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$' . $price;

        return $price;
    }

    public function unserializeFilter($serial_str) {
        return unserialize($serial_str);
    }

    public function bcmodFilter($number, $mod) {
        $pathnumber = strval($number);
        return bcmod($pathnumber, $mod);
    }

    public function bcdivFilter($number, $mod) {
        $pathnumber = strval($number);
        return bcdiv($pathnumber, $mod);
    }

    public function imgpathFilter($number) {
        $pathnumber = strval($number);
        $imgpath = '';
        for ($i = 0; $i < strlen($pathnumber); $i++) {
            if ($i == 0)
                $imgpath = $pathnumber[$i];
            else
                $imgpath = $imgpath . '/' . $pathnumber[$i];
        }
        //  $imgpath = $imgpath.'-'. $type.'.jpg';

        return $imgpath;
    }

    public function getName() {
        return 'map2u_extension';
    }

}
