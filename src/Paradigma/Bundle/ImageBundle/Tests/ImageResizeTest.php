<?php

namespace Paradigma\Bundle\ImageBundle\Tests;

use Paradigma\Bundle\ImageBundle\Libs\ImageResizer;
use Paradigma\Bundle\ImageBundle\Libs\ImageSize;

class ImageResizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ImageResizer
     */
    private function getImageResizer()
    {
        return new ImageResizer();
    }

    /**
     * Test the image resize
     */
    public function testResize()
    {
        $imageResizer = $this->getImageResizer();

        $filename_input  = __DIR__ . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'test.jpg';
        $filename_output = __DIR__ . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'test_16.jpg';

        $imageResizer->resize($filename_input, $filename_output, new ImageSize(16, 16), ImageResizer::RESIZE_TYPE_EXACT);

        $this->assertTrue(file_exists($filename_output));

        $img = imagecreatefromjpeg($filename_output);
        $this->assertEquals("16", imagesx($img));
        $this->assertEquals("16", imagesy($img));
        imagedestroy($img);

        @unlink($filename_output);
    }

}
