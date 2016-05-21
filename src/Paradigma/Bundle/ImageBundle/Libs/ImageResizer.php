<?php

namespace Paradigma\Bundle\ImageBundle\Libs;

/**
 * Class ImageResizer
 * @package Paradigma\Bundle\ImageBundle\Libs
 */
class ImageResizer
{
    const RESIZE_TYPE_AUTO = 'auto';
    const RESIZE_TYPE_CROP = 'crop';
    const RESIZE_TYPE_EXACT = 'exact';
    const RESIZE_TYPE_PORTRAIT = 'portrait';
    const RESIZE_TYPE_LANDSCAPE = 'landscape';

    /**
     * @param $input
     * @param $output
     * @param ImageSize $expectedSize
     * @param string $resize_type
     * @param int $quality
     * @return bool
     */
    public function resize($input, $output, ImageSize $expectedSize, $resize_type = ImageResizer::RESIZE_TYPE_AUTO, $quality = 80)
    {
        $img = imagecreatefromstring(file_get_contents($input));

        if (!$img) {
            // if can't open and create the image
            return false;
        }

        if (function_exists('exif_imagetype')) {
            $type = exif_imagetype($input);
        } else {
            $info = getimagesize($input);
            $type = $info[2];
            unset($info);
        }


        $originalSize = new ImageSize(imagesx($img), imagesy($img));

        // Get optimal size based on resizing type
        $newSize = $originalSize->getResizedSize($expectedSize, $resize_type);

        $imageResized = $this->resizeImage($img, $type, $originalSize, $newSize);

        if ($resize_type === ImageResizer::RESIZE_TYPE_CROP) {
            $imageResized = $this->crop($imageResized, $type, $newSize, $expectedSize);
        }

        return $this->saveImage($imageResized, $type, $output, $quality);
    }

    /**
     * @param $img
     * @param $type
     * @param ImageSize $originalSize
     * @param ImageSize $newSize
     * @return resource
     */
    private function resizeImage($img, $type, ImageSize $originalSize, ImageSize $newSize)
    {
        // Create image canvas of x, y size
        $imageResized = imagecreatetruecolor($newSize->getWidth(), $newSize->getHeight());

        /* start edit */
        switch ($type) {
            case IMAGETYPE_PNG:
                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($imageResized, 255, 0, 0);
                // removing the black from the placeholder
                imagecolortransparent($imageResized, $background);

                // turning off alpha blending (to ensure alpha channel information
                // is preserved, rather than removed (blending with the rest of the
                // image in the form of black))
                imagealphablending($imageResized, false);

                // turning on alpha channel information saving (to ensure the full range
                // of transparency is preserved)
                imagesavealpha($imageResized, true);

                break;

            case IMAGETYPE_GIF:
                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($imageResized, 255, 255, 255);
                // removing the black from the placeholder
                imagecolortransparent($imageResized, $background);

                break;
        }
        /* end edit */

        imagecopyresampled($imageResized, $img, 0, 0, 0, 0,
            $newSize->getWidth(), $newSize->getHeight(),
            $originalSize->getWidth(), $originalSize->getHeight()
        );

        return $imageResized;
    }

    /**
     * @param $img
     * @param $type
     * @param ImageSize $newSize
     * @param ImageSize $expectedSize
     * @return resource
     */
    private function crop($img, $type, ImageSize $newSize, ImageSize $expectedSize)
    {
        // Find center - this will be used for the crop
        $cropStartX = ($newSize->getWidth() / 2) - ($expectedSize->getWidth() / 2);
        $cropStartY = ($newSize->getHeight() / 2) - ($expectedSize->getHeight()/ 2);

        // Now crop from center to exact requested size
        $imageCropped = imagecreatetruecolor($expectedSize->getWidth(), $expectedSize->getHeight());

        switch ($type) {
            case IMAGETYPE_PNG:
                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($imageCropped, 255, 0, 0);
                // removing the black from the placeholder
                imagecolortransparent($imageCropped, $background);

                // turning off alpha blending (to ensure alpha channel information
                // is preserved, rather than removed (blending with the rest of the
                // image in the form of black))
                imagealphablending($imageCropped, false);

                // turning on alpha channel information saving (to ensure the full range
                // of transparency is preserved)
                imagesavealpha($imageCropped, true);

                break;

            case IMAGETYPE_GIF:
                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($imageCropped, 255, 255, 255);
                // removing the black from the placeholder
                imagecolortransparent($imageCropped, $background);

                break;
        }

        imagecopyresampled($imageCropped, $img, 0, 0, $cropStartX, $cropStartY,
            $expectedSize->getWidth(), $expectedSize->getHeight(),
            $expectedSize->getWidth(), $expectedSize->getHeight()
        );

        return $imageCropped;
    }

    /**
     * @param $img
     * @param $type
     * @param $path
     * @param int $quality
     * @return bool
     */
    private function saveImage($img, $type, $path, $quality = 80)
    {
        $return_value = false;

        switch ($type) {
            case IMAGETYPE_JPEG:
                if (imagetypes() & IMG_JPG) {
                    $return_value = imagejpeg($img, $path, $quality);
                }
                break;

            case IMAGETYPE_GIF:
                if (imagetypes() & IMG_GIF) {
                    $return_value = imagegif($img, $path);
                }
                break;

            case IMAGETYPE_PNG:
                // Scale quality from 0-100 to 0-9 and invert for PNG
                $png_quality = 9 - round(($quality / 100) * 9);

                if (imagetypes() & IMG_PNG) {
                    $return_value = imagepng($img, $path, $png_quality);
                }
                break;
        }

        imagedestroy($img);

        return $return_value;
    }
}
