<?php

namespace Map2u\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Types\Type;
use Map2u\CoreBundle\Classes\Map2uPDF;

//use \Imagick;

Type::overrideType('datetime', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('datetimetz', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('time', 'Doctrine\DBAL\Types\VarDateTimeType');
#define('PDF_MARGIN_HEADER', 10);
/**
 * map2u_core controller.
 *
 * @Route("/map2ucore")
 */

class DefaultController extends Controller {

  public function indexAction($name) {
    return $this->render('Map2uCoreBundle:Default:index.html.twig', array('name' => $name));
  }

  /**
   * Lists all BenthicCollections entities.
   *
   * @Route("/createpdf", name="map2ucore_createpdf")
   * @Method("GET")
   * @Template()
   */
  public function createpdfmapAction() {

   $request=$this->getRequest(); 
    $layers=$request->get('layers');
    $extent=$request->get('extent');
    $size=$request->get('size');
 //   var_dump($size);

    $extent_array=explode(",",$extent);
    $size_array=  explode("x", $size);
    
    $rate= abs((floatval($extent_array[1])-floatval($extent_array[3]))/(floatval($extent_array[0])-floatval($extent_array[2])));
    
    $level=$request->get('level');
    $center=$request->get('center');
    
    $host="http://cobas.juturna.ca:8080/geoserver/cobasvirtual/wms";
    
    
    $pdfObj = new Map2uPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdfObj->AddPage();
    $pdfObj->Ln(10);
    $pdfObj->write(2, "1.0 Site Description");
    // column titles
//    $pdfObj->Ln();
     $max_width = 180;
    $max_height = intval(floatval($max_width)*$rate);
    $map_width=640;;
    $map_height=640*$size_array[1]/floatval($size_array[0]);//intval(floatval($map_width)*$rate);
    $url="http://maps.googleapis.com/maps/api/staticmap?center=".$center."&zoom=".$level."&size=".$map_width."x".$map_height."&sensor=false";
    
    $mapdata = http_get($url);
   echo $url."<br>";
//    $mapdata = http_get("http://dev.virtualearth.net/REST/V1/Imagery/Map/Road/space%20needle,seattle?mapLayer=TrafficFlow&mapVersion=v1&key=AlkdEy1SbQunXXg1BzwEc91j47euCKkYw8r0_wu6OP24I9QL68Ywuk1eFWjB3LR0");
    $body = http_parse_message($mapdata)->body;

    $pdfObj->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $_filename1 = 'tmp/tmpfile' . microtime(true) . '.jpeg';
    file_put_contents($_filename1, $body);
    //   $pdfObj->Ln();
    //  $pdfObj->Rect(15 + 55, 160, 52, 70);
    list($width, $height) = getimagesize($_filename1);
    $ratioh = $max_height / $height;
    $ratiow = $max_width / $width;
    $ratio = min($ratioh, $ratiow);
// New dimensions
    $width = intval($ratio * $width);
    $height = intval($ratio * $height);

    //  $pdfObj->Image($_filename, 15 + 55, 160, $width, $height);   

    $mapdata = http_get("http://maps.superdemographics.com:8086/geoserver/manifold/wms?service=WMS&version=1.1.0&request=GetMap&layers=manifold:gcsd11a_ke2012_35&styles=&bbox=-82.11251,42.38515,-79.53149,44.24471&width=512&height=331&srs=EPSG:4326&transparent=true&format=image%2Fpng");
    $body = http_parse_message($mapdata)->body;
    $pdfObj->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $_filename2 = 'tmp/tmpfile' . microtime(true) . '.jpeg';
    file_put_contents($_filename2, $body);
    //   $pdfObj->Ln();
    //  $pdfObj->Rect(15 + 55, 160, 52, 70);
    list($width, $height) = getimagesize($_filename2);
    $ratioh = $max_height / $height;
    $ratiow = $max_width / $width;
    $ratio = min($ratioh, $ratiow);
// New dimensions
    $width = intval($ratio * $width);
    $height = intval($ratio * $height);

    $img1 = new \Imagick($_filename1);
    $img2 = new \Imagick($_filename2);

    $img1->compositeImage($img2, \Imagick::COMPOSITE_OVER, 0, 0);

    $_filename3 = 'tmp/tmpfile' . microtime(true) . '.jpeg';

    $img1->setImageFileName($_filename3);

    // Let's write the image. 
    if (FALSE == $img1->writeImage()) {
      throw new Exception();
    }

    $pdfObj->Image($_filename3,15, 30, $width, $height);


    // $this->getBingMap($pdfObj);
    if (file_exists($_filename1)) {
        unlink($_filename1);
    }
    if (file_exists($_filename2)) {
        unlink($_filename2);
    }
    if (file_exists($_filename3)) {
        unlink($_filename3);
    }
    $pdfObj->Output('station_report.pdf', 'I');
  }

  private function getBingMap($pdfObj) {
    $max_width = 150;
    $max_height = 110;
    $mapdata = http_get("http://dev.virtualearth.net/REST/V1/Imagery/Map/Road/space%20needle,seattle?mapLayer=TrafficFlow&mapVersion=v1&key=AlkdEy1SbQunXXg1BzwEc91j47euCKkYw8r0_wu6OP24I9QL68Ywuk1eFWjB3LR0");
    $body = http_parse_message($mapdata)->body;

    $pdfObj->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $_filename = 'tmp/tmpfile' . microtime(true) . '.jpeg';
    file_put_contents($_filename, $body);
    $pdfObj->Ln();
    $pdfObj->Rect(15 + 55, 160, 52, 70);
    list($width, $height) = getimagesize($_filename);
    $ratioh = $max_height / $height;
    $ratiow = $max_width / $width;
    $ratio = min($ratioh, $ratiow);
// New dimensions
    $width = intval($ratio * $width);
    $height = intval($ratio * $height);

    $pdfObj->Image($_filename, 15 + 55, 160, $width, $height);
  }

}

//
//  $request=$this->getRequest();
//    $extent=$request->get("extent");
//    $extent_array=explode(",",$extent);
//    $rate= abs((floatval($extent_array[1])-floatval($extent_array[3]))/(floatval($extent_array[0])-floatval($extent_array[2])));
//    $center=$request->get("center");
//    $level=$request->get("level");
//    
//    $pdfObj = new Map2uPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//   $pdfObj->AddPage();
//    $pdfObj->Ln(10);
//        $pdfObj->write(2, "1.0 Site Description");
//        // column titles
//        $pdfObj->Ln();
//     $max_width = 180;
//    $max_height = intval(floatval($max_width)*$rate);
//    $map_width=800;
//    $map_height=intval(floatval($map_width)*$rate);
//    // http://dev.virtualearth.net/REST/v1/Imagery/Map/imagerySet?mapArea=mapArea&mapSize=mapSize&pushpin=pushpin&mapLayer=mapLayer&format=format&mapMetadata=mapMetadata&key=BingMapsKey
//    
//   //   echo "http://dev.virtualearth.net/REST/V1/Imagery/Map/Road?mapArea=".$extent[3].",".$extent[2].",".$extent[1].",".$extent[0]."&mapSize=600,800&mapVersion=v1&key=AlkdEy1SbQunXXg1BzwEc91j47euCKkYw8r0_wu6OP24I9QL68Ywuk1eFWjB3LR0";
//  //echo "http://dev.virtualearth.net/REST/V1/Imagery/Map/Road?mapArea=".$extent_array[1].",".$extent_array[0].",".$extent_array[3].",".$extent_array[2]."&mapSize=".$map_width.",".$map_height."&mapVersion=v1&key=AlkdEy1SbQunXXg1BzwEc91j47euCKkYw8r0_wu6OP24I9QL68Ywuk1eFWjB3LR0";
//  $url="http://dev.virtualearth.net/REST/V1/Imagery/Map/Road?mapArea=".$extent_array[1].",".$extent_array[0].",".$extent_array[3].",".$extent_array[2]."&mapSize=".$map_width.",".$map_height."&mapMetaData=1&o=json&mapVersion=v1&key=AlkdEy1SbQunXXg1BzwEc91j47euCKkYw8r0_wu6OP24I9QL68Ywuk1eFWjB3LR0";
// // $url= "http://dev.virtualearth.net/REST/V1/Imagery/Map/Road/".$center."/".($level+3)."?mapSize=".$map_width.",".$map_height."&mapVersion=v1&key=AlkdEy1SbQunXXg1BzwEc91j47euCKkYw8r0_wu6OP24I9QL68Ywuk1eFWjB3LR0";
//   $url2="http://maps.superdemographics.com:8086/geoserver/manifold/wms?service=WMS&version=1.1.0&request=GetMap&layers=manifold:gcsd11a_ke2012_35&styles=&bbox=".$extent."&width=".$map_width."&height=".$map_height."&srs=EPSG:4326&transparent=true&format=image%2Fpng";
//  //   echo $url."<br>";
// //    echo $url2."<br>";
////    $mapdata1 = http_get("http://dev.virtualearth.net/REST/V1/Imagery/Map/Road?mapArea=".$extent_array[1].",".$extent_array[0].",".$extent_array[3].",".$extent_array[2]."&mapSize=".$map_width.",".$map_height."&mapVersion=v1&key=AlkdEy1SbQunXXg1BzwEc91j47euCKkYw8r0_wu6OP24I9QL68Ywuk1eFWjB3LR0");
//    $mapdata1 = http_get($url);
//  $url= "http://dev.virtualearth.net/REST/V1/Imagery/Map/Road/".$center."/".($level+3)."?mapSize=".$map_width.",".$map_height."&mapVersion=v1&key=AlkdEy1SbQunXXg1BzwEc91j47euCKkYw8r0_wu6OP24I9QL68Ywuk1eFWjB3LR0";
//
//    $body1 = http_parse_message($mapdata1)->body;
////echo $body1."<br>";
//    $bodyjson=json_decode($body1, true);
////echo $bodyjson['resourceSets']['resources']['bbox']."<br>";
//    $resourcesset=$bodyjson['resourceSets'][0];
//    $bbox=$resourcesset['resources'][0]['bbox'];
//    
//    $scale= floatval($bbox[0]-$bbox[2])/floatval($extent_array[1]-$extent_array[3]);
//    
//        
//  //  var_dump($resourcesset['resources'][0]['bbox'])."<br>";
//  $url="http://dev.virtualearth.net/REST/V1/Imagery/Map/Road?mapArea=".$extent_array[1].",".$extent_array[0].",".$extent_array[3].",".$extent_array[2]."&mapSize=".$map_width.",".$map_height."&mapVersion=v1&key=AlkdEy1SbQunXXg1BzwEc91j47euCKkYw8r0_wu6OP24I9QL68Ywuk1eFWjB3LR0";
//    $mapdata1 = http_get($url);
//
//     $body1 = http_parse_message($mapdata1)->body;
//    
//    $pdfObj->setImageScale(PDF_IMAGE_SCALE_RATIO);
//    $_filename1 = 'tmp/tmpfile' . microtime(true) . '.jpeg';
//    file_put_contents($_filename1, $body1);
// //   $pdfObj->Ln();
//  //  $pdfObj->Rect(15 + 55, 160, 52, 70);
//    list($width, $height) = getimagesize($_filename1);
//    $ratioh = $max_height / $height;
//    $ratiow = $max_width / $width;
//    $ratio = min($ratioh, $ratiow);
//// New dimensions
//    $width = intval($ratio * $width);
//    $height = intval($ratio * $height);
//
//  //  $pdfObj->Image($_filename, 15 + 55, 160, $width, $height);   
//    $url2="http://maps.superdemographics.com:8086/geoserver/manifold/wms?service=WMS&version=1.1.0&request=GetMap&layers=manifold:gcsd11a_ke2012_35&styles=&bbox=".$bbox[1].",".$bbox[0].",".$bbox[3].",".$bbox[2]."&width=".$map_width."&height=".$map_height."&srs=EPSG:4326&transparent=true&format=image%2Fpng";
//  //  echo $url2."<br>";
//    $mapdata = http_get($url2);
//  //      $mapdata = http_get("http://maps.superdemographics.com:8086/geoserver/manifold/wms?service=WMS&version=1.1.0&request=GetMap&layers=manifold:gcsd11a_ke2012_35&styles=&bbox=".$extent."&width=".$map_width."&height=".$map_height."&srs=EPSG:4326&transparent=true&format=image%2Fpng");
//    $body = http_parse_message($mapdata)->body;
//    $pdfObj->setImageScale(PDF_IMAGE_SCALE_RATIO);
//    $_filename2 = 'tmp/tmpfile' . microtime(true) . '.jpeg';
//    file_put_contents($_filename2, $body);
// //   $pdfObj->Ln();
//  //  $pdfObj->Rect(15 + 55, 160, 52, 70);
//    list($width, $height) = getimagesize($_filename2);
//    $ratioh = $max_height / $height;
//    $ratiow = $max_width / $width;
//    $ratio = min($ratioh, $ratiow);
//// New dimensions
//    $width = intval($ratio * $width);
//    $height = intval($ratio * $height);
//
//    $img1 = new \Imagick($_filename1 );
//    $img2 = new \Imagick( $_filename2 );
//  //  echo $scale."<br>";
// 
//    $img1->compositeImage( $img2, \Imagick::COMPOSITE_OVER, 0,0 );
//    
//  //  $size=$img1->getImageLength();
//    $height1=$img1->getImageHeight();
//    $width1=$img1->getImageWidth();
// //    echo $width."  ".$height."<br>";
//     $img1->scaleImage($scale*$width1, $scale*$height1);
// //   var_dump($size);
//      $height2=$img1->getimageheight();
//      $width2=$img1->getImageWidth();
//    
//   // echo $width."  ".$height."<br>";
//  //  echo $size['columns']." ".$size['rows'];
//  // $size2=$img2->getImageLength();
// //   var_dump($size2);
//     $img1->cropImage($width1,$height1,($width2-$width1)/2, ($height2-$height1)/2);
//     
//    
//      $_filename3 = 'tmp/tmpfile' . microtime(true) . '.jpeg';
//  
//    $img1->setImageFileName($_filename3); 
//
//    // Let's write the image. 
//    if  (FALSE == $img1->writeImage()) 
//    { 
//        throw new Exception(); 
//    } 
//   
//    $pdfObj->Image($_filename3, 15, 30, $width, $height);   
//
//    
//   // $this->getBingMap($pdfObj);
//    $pdfObj->Output('station_report.pdf', 'I');