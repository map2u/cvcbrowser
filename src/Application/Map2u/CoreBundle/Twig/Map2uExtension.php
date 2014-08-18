<?php

// src/Map2u/WebgisBundle/Twig/Map2uExtension.php
namespace Application\Map2u\CoreBundle\Twig;

class Map2uExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'imgpath' => new \Twig_Filter_Method($this, 'imgpathFilter'),
            'bcmod' => new \Twig_Filter_Method($this, 'bcmodFilter'),
            'bcdiv' => new \Twig_Filter_Method($this, 'bcdivFilter'),
            'price' => new \Twig_Filter_Method($this, 'priceFilter'),
            'unserialize'=>new \Twig_Filter_Method($this, 'unserializeFilter'),
        );
    }
    
    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$' . $price;

        return $price;
    }
    public function unserializeFilter($serial_str)
    {
        return unserialize($serial_str);
    }
    public function bcmodFilter($number,$mod)
    {
        $pathnumber=strval($number);
        return bcmod($pathnumber,$mod);
    }
    public function bcdivFilter($number,$mod)
    {
        $pathnumber=strval($number);
        return bcdiv($pathnumber,$mod);
    }
    
    public function imgpathFilter($number)
    {
        $pathnumber=strval($number);
        $imgpath='';
        for($i=0;$i< strlen($pathnumber); $i++)
        {
            if($i==0)
               $imgpath= $pathnumber[$i];
            else
               $imgpath= $imgpath.'/'.$pathnumber[$i];
        }
      //  $imgpath = $imgpath.'-'. $type.'.jpg';

        return $imgpath;
    }

    public function getName()
    {
        return 'map2u_extension';
    }
}