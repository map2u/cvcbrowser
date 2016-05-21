<?php

namespace Paradigma\Bundle\ImageBundle\Libs;

/**
 * Class ImageSize
 * @package Paradigma\Bundle\ImageBundle\Lib
 */
class ImageSize {

    const RELATION_WIDTH    = 'width';
    const RELATION_HEIGHT   = 'height';

    /**
     * @var
     */
    private $width;

    /**
     * @var
     */
    private $height;

    /**
     * @param $width
     * @param $height
     */
    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param string $relation
     * @return float
     */
    public function getRatio($relation = ImageSize::RELATION_WIDTH)
    {
        if ($relation === ImageSize::RELATION_HEIGHT) {
            return $this->getHeight() / $this->getWidth();
        } else {
            return $this->getWidth() / $this->getHeight();
        }
    }

    /**
     * @param ImageSize $originalSize
     * @param ImageSize $newSize
     * @param $resize_type
     * @return ImageSize
     */
    public function getResizedSize(ImageSize $newSize, $resize_type)
    {
        switch ($resize_type) {
            case ImageResizer::RESIZE_TYPE_EXACT:
                return $newSize;
                break;

            case ImageResizer::RESIZE_TYPE_PORTRAIT:
                return new ImageSize(
                    $this->getSizeByFixedHeight($newSize->getHeight()),
                    $newSize->getHeight()
                );
                break;

            case ImageResizer::RESIZE_TYPE_LANDSCAPE:
                return new ImageSize(
                    $newSize->getWidth(),
                    $this->getSizeByFixedWidth($newSize->getWidth())
                );
                break;

            case ImageResizer::RESIZE_TYPE_CROP:
                return $this->getOptimalCrop($newSize);
                break;

            case ImageResizer::RESIZE_TYPE_AUTO:
            default:
                return $this->getSizeByAuto($newSize);
                break;
        }
    }

    /**
     * @param ImageSize $originalSize
     * @param $newHeight
     * @return mixed
     */
    private function getSizeByFixedHeight($newHeight)
    {
        $ratio = $this->getRatio();
        $newWidth = $newHeight * $ratio;

        return $newWidth;
    }

    /**
     * @param ImageSize $originalSize
     * @param $newWidth
     * @return mixed
     */
    private function getSizeByFixedWidth($newWidth)
    {
        $ratio = $this->getRatio(ImageSize::RELATION_HEIGHT);
        $newHeight = $newWidth * $ratio;

        return $newHeight;
    }

    /**
     * @param ImageSize $originalSize
     * @param ImageSize $newSize
     * @return ImageSize
     */
    private function getSizeByAuto(ImageSize $newSize)
    {
        if ($this->getHeight() < $this->getWidth()) { // Image to be resized is wider (landscape)
            return new ImageSize(
                $newSize->getWidth(),
                $this->getSizeByFixedWidth($newSize->getWidth())
            );
        } elseif ($this->getHeight() > $this->getWidth()) { // Image to be resized is taller (portrait)
            return new ImageSize(
                $this->getSizeByFixedHeight($newSize->getHeight()),
                $newSize->getHeight()
            );
        } else { // Image to be resized is a square
            if ($newSize->getHeight() < $newSize->getWidth()) {
                return new ImageSize(
                    $newSize->getWidth(),
                    $this->getSizeByFixedWidth($newSize->getWidth())
                );
            } else if ($newSize->getHeight() > $newSize->getWidth()) {
                return new ImageSize(
                    $this->getSizeByFixedHeight($newSize->getHeight()),
                    $newSize->getHeight()
                );
            } else { // Square being resized to a square
                return $newSize;
            }
        }
    }

    /**
     * @param ImageSize $originalSize
     * @param ImageSize $newSize
     * @return ImageSize
     */
    private function getOptimalCrop(ImageSize $newSize)
    {
        $widthRatio = $this->getWidth() / $newSize->getWidth();
        $heightRatio = $this->getHeight() / $newSize->getHeight();

        if ($heightRatio < $widthRatio) {
            return new ImageSize(
                $this->getWidth() / $heightRatio,
                $this->getHeight() / $heightRatio
            );
        } else {
            return new ImageSize(
                $this->getWidth() / $widthRatio,
                $this->getHeight() / $widthRatio
            );
        }
    }
}
