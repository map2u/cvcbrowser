<?php

namespace Application\Map2u\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HomePageHeader
 */
class HomePageHeader
{
    /**
     * @var array
     */
    private $headerLogo;

    /**
     * @var string
     */
    private $menubarLogo;

    /**
     * @var string
     */
    private $headerTitle;

    /**
     * @var string
     */
    private $headerTitleColor;

    /**
     * @var string
     */
    private $headerBackgroundImage;

    /**
     * @var string
     */
    private $systemBackgroundImage;

    /**
     * @var float
     */
    private $headerBackgroundImageOpacity;

    /**
     * @var float
     */
    private $systemBackgroundImageOpacity;


    /**
     * Set headerLogo
     *
     * @param array $headerLogo
     * @return HomePageHeader
     */
    public function setHeaderLogo($headerLogo)
    {
        $this->headerLogo = $headerLogo;

        return $this;
    }

    /**
     * Get headerLogo
     *
     * @return array 
     */
    public function getHeaderLogo()
    {
        return $this->headerLogo;
    }

    /**
     * Set menubarLogo
     *
     * @param string $menubarLogo
     * @return HomePageHeader
     */
    public function setMenubarLogo($menubarLogo)
    {
        $this->menubarLogo = $menubarLogo;

        return $this;
    }

    /**
     * Get menubarLogo
     *
     * @return string 
     */
    public function getMenubarLogo()
    {
        return $this->menubarLogo;
    }

    /**
     * Set headerTitle
     *
     * @param string $headerTitle
     * @return HomePageHeader
     */
    public function setHeaderTitle($headerTitle)
    {
        $this->headerTitle = $headerTitle;

        return $this;
    }

    /**
     * Get headerTitle
     *
     * @return string 
     */
    public function getHeaderTitle()
    {
        return $this->headerTitle;
    }

    /**
     * Set headerTitleColor
     *
     * @param string $headerTitleColor
     * @return HomePageHeader
     */
    public function setHeaderTitleColor($headerTitleColor)
    {
        $this->headerTitleColor = $headerTitleColor;

        return $this;
    }

    /**
     * Get headerTitleColor
     *
     * @return string 
     */
    public function getHeaderTitleColor()
    {
        return $this->headerTitleColor;
    }

    /**
     * Set headerBackgroundImage
     *
     * @param string $headerBackgroundImage
     * @return HomePageHeader
     */
    public function setHeaderBackgroundImage($headerBackgroundImage)
    {
        $this->headerBackgroundImage = $headerBackgroundImage;

        return $this;
    }

    /**
     * Get headerBackgroundImage
     *
     * @return string 
     */
    public function getHeaderBackgroundImage()
    {
        return $this->headerBackgroundImage;
    }

    /**
     * Set systemBackgroundImage
     *
     * @param string $systemBackgroundImage
     * @return HomePageHeader
     */
    public function setSystemBackgroundImage($systemBackgroundImage)
    {
        $this->systemBackgroundImage = $systemBackgroundImage;

        return $this;
    }

    /**
     * Get systemBackgroundImage
     *
     * @return string 
     */
    public function getSystemBackgroundImage()
    {
        return $this->systemBackgroundImage;
    }

    /**
     * Set headerBackgroundImageOpacity
     *
     * @param float $headerBackgroundImageOpacity
     * @return HomePageHeader
     */
    public function setHeaderBackgroundImageOpacity($headerBackgroundImageOpacity)
    {
        $this->headerBackgroundImageOpacity = $headerBackgroundImageOpacity;

        return $this;
    }

    /**
     * Get headerBackgroundImageOpacity
     *
     * @return float 
     */
    public function getHeaderBackgroundImageOpacity()
    {
        return $this->headerBackgroundImageOpacity;
    }

    /**
     * Set systemBackgroundImageOpacity
     *
     * @param float $systemBackgroundImageOpacity
     * @return HomePageHeader
     */
    public function setSystemBackgroundImageOpacity($systemBackgroundImageOpacity)
    {
        $this->systemBackgroundImageOpacity = $systemBackgroundImageOpacity;

        return $this;
    }

    /**
     * Get systemBackgroundImageOpacity
     *
     * @return float 
     */
    public function getSystemBackgroundImageOpacity()
    {
        return $this->systemBackgroundImageOpacity;
    }
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
