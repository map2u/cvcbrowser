<?php

namespace Paradigma\Bundle\ImageBundle\Tests;

use Paradigma\Bundle\ImageBundle\Libs\ImageResizer;
use Paradigma\Bundle\ImageBundle\Libs\ImageSize;

class ImageSizeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the image resize
     */
    public function testSize()
    {
        $imageSize = new ImageSize(10, 10);

        $this->assertEquals(1, $imageSize->getRatio(ImageSize::RELATION_WIDTH));
        $this->assertEquals(1, $imageSize->getRatio(ImageSize::RELATION_HEIGHT));

        $resizeImageSize = $imageSize->getResizedSize(new ImageSize(5, 10), ImageResizer::RESIZE_TYPE_EXACT);
        $this->assertEquals(5, $resizeImageSize->getWidth());
        $this->assertEquals(10, $resizeImageSize->getHeight());

        $resizeImageSize = $imageSize->getResizedSize(new ImageSize(5, 10), ImageResizer::RESIZE_TYPE_CROP);
        $this->assertEquals(10, $resizeImageSize->getWidth());
        $this->assertEquals(10, $resizeImageSize->getHeight());

        $resizeImageSize = $imageSize->getResizedSize(new ImageSize(5, 5), ImageResizer::RESIZE_TYPE_AUTO);
        $this->assertEquals(5, $resizeImageSize->getWidth());
        $this->assertEquals(5, $resizeImageSize->getHeight());

        $resizeImageSize = $imageSize->getResizedSize(new ImageSize(5, 10), ImageResizer::RESIZE_TYPE_LANDSCAPE);
        $this->assertEquals(5, $resizeImageSize->getWidth());
        $this->assertEquals(5, $resizeImageSize->getHeight());

        $resizeImageSize = $imageSize->getResizedSize(new ImageSize(5, 10), ImageResizer::RESIZE_TYPE_PORTRAIT);
        $this->assertEquals(10, $resizeImageSize->getWidth());
        $this->assertEquals(10, $resizeImageSize->getHeight());
    }

}
