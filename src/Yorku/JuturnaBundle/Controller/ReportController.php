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
 * <summary>This file is created for Report controller with bundle YorkuJuturnaBundle</summary>
 * <purpose>all Report related actions process in this controller</purpose>
 */

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\DBAL\Types\Type;
use Map2u\WebgisBundle\Classes\Map2uPDF;

//use \Imagick;

Type::overrideType('datetime', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('datetimetz', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('time', 'Doctrine\DBAL\Types\VarDateTimeType');
define('PDF_MARGIN_HEADER', 10);

/**
 * Report controller.
 *
 * @Route("/report")
 */
class ReportController extends Controller {

    /**
     * Lists all BenthicCollections entities.
     *
     * @Route("/station", name="report_station")
     * @Method("GET")
     * @Template()
     */
    public function stationAction() {

//        $pdfObj = new Map2uPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//        // $image=new \Imagick;
//        $em = $this->getDoctrine()->getManager();
//        $request = $this->getRequest();
//
//        // get request search conditions for creating report
//        $station_name = $request->get('id');
//        $description_id = $request->get('description');
//        $benthic_id = $request->get('benthic');
//        $waterchemistry_id = $request->get('waterchemistry');
//
////description=93&benthic=44&waterchemistry=null
//        //   $pdfObj = $this->container->get("white_october.tcpdf")->create();
//        $pdfObj->SetTitle('Station Report ' . $station_name);
//        $station = $em->getRepository('YorkuJuturnaBundle:Stations')->findOneByStationName($station_name);
//        $description = $em->getRepository('YorkuJuturnaBundle:SiteDescriptions')->findOneById($description_id);
//        $benthic = $em->getRepository('YorkuJuturnaBundle:Benthics')->findOneById($benthic_id);
//        $waterchemistry = $em->getRepository('YorkuJuturnaBundle:WaterChemistries')->findOneById($waterchemistry_id);
//
//        $pdfObj->footertext = "This was report produced on " . date('Y-m-d H:i:s') . " at www.juturna.ca. Disclaimer: Data provided in this
//report is not guaranteed to be error free. Neither the TRCA, EcoSpark nor any of their contributing
//partners or funders shall be liable for any errors or omissions in the published content, or for any
//actions taken in reliance thereon.";
//
//        $this->writeReportHeader($pdfObj, $station_name);
//        $pdfObj->Ln(10);
//        $pdfObj->write(2, "1.0 Site Description");
//        // column titles
//        $pdfObj->Ln();
//        $header = array();
//        $data = array();
//        //     var_dump($station->getTheGeom());
//        //     
//        // data loading
//        array_push($data, array('Station Name', $station_name));
//        if($station->getCreatedAt())
//            array_push($data, array('Station Established On', $station->getCreatedAt()->format('Y-m-d H:i:s')));
//        else
//            array_push($data, array('Station Established On', 'No data'));
//            
//        array_push($data, array('Watershed', $station->getWatershed()->getWatershedName()));
//        array_push($data, array('Subwatershed', $station->getSubwatershed()->getSubwatershedName()));
//        array_push($data, array('Municipality', $station->getMunicipality()));
//        array_push($data, array('Nearest Intersection', $station->getNearestIntersection()));
//        array_push($data, array('Geographic Location', 'Lat:' . sprintf("%.3f", $station->getTheGeom()->getX()) . ' Lng: ' . sprintf("%.3f", $station->getTheGeom()->getY())));
//        array_push($data, array('Datum', 'WGS84'));
//        array_push($data, array('The Last Update For This Station', $station->getUpdatedAt()->format('Y-m-d H:i:s')));
//
//        $this->SiteDescriptionTable($pdfObj, $header, $data);
//        $this->SiteDescriptionPictures($pdfObj, $description);
//        $pdfObj->Output('station_report_' . $station_name . '.pdf', 'I');
        //      return $this->render(sprintf('YorkuJuturnaBundle:Report:station.%s.twig', $format), array('station' => $station));
    }

    protected function SiteDescriptionPictures($pdf, $description) {
        //         $pdf->writeHTML(count($description->sitepictures), true, false, true, false, 'J');

        if ($description AND $description->getSitepictures()) {
            $i = 0;
            $max_width = 52;
            $max_height = 70;
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            foreach ($description->getSitepictures() as $picture) {
                if ($i < 3) {
                    //   $pdf->writeHTML("dddd", true, false, true, false, 'J');
                    $pdf->Ln();
                    $pdf->Rect(15 + 55 * $i, 160, 52, 70);

                    $_filename = 'tmpfile' . microtime(true);
                    //  $im = imagecreatefromstring($picture->getBlobData());

                    file_put_contents($_filename, $picture->getBlobData());
                    list($width, $height) = getimagesize($_filename);
                    $ratioh = $max_height / $height;
                    $ratiow = $max_width / $width;
                    $ratio = min($ratioh, $ratiow);
// New dimensions
                    $width = intval($ratio * $width);
                    $height = intval($ratio * $height);

                    $pdf->Image($_filename, 15 + 55 * $i, 160, $width, $height);
                    //pdf.fill_stroke
                    // pdf.pointer=220
                    if ($picture->getName()) {
                        $pdf->SetXY(16 + 55 * $i, 231);
                        $pdf->cell(0, 0, ($i + 1) . '. ' . $picture->getName());
                        // pdf.fill_stroke
                    }

                    //	pdf.pointer=740
                    //        if picture.blob_data
                    //	   pdf.add_image picture.blob_data,pdf.left_margin + 25+ 160*i,230,155,120
                    //       end
                }
                $i = $i + 1;
            }
        }
    }

    protected function writeReportHeader($pdf, $station_name) {

        $pdf->SetHeaderData('', 10, "Water Quality Monitoring Station Report for site " . $station_name, null, array(0, 0, 0), array(0, 0, 0));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
// set header and footer fonts
// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 15));
        //       $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

// set text shadow effect
        //    $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
// Set some content to print
        $html = <<<EOD
This report presents data and water quality indicators based on volunteer community-
based environmental monitoring programs. Community monitoring supports public
education on the science behind environmental processes and enables more
meaningful public involvement in decision making processes related to
environmental management. For more information on the community monitoring
programs linked to this report visit http://www.ecospark.ca
EOD;

// Print text using writeHTMLCell()
        // $h=0, $txt, $link='', $fill=0, $align='C', $ln=true, $stretch=0
        //    $pdf->write(2, $html,'',0,'',true,1);
        // 	writeHTML ($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
        $pdf->writeHTML($html, true, false, true, false, 'J');
        //       $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    }

    protected function SiteDescriptionTable($pdf, $header, $data) {
        // Colors, line width and bold font
        $pdf->SetFillColor(186);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('', 'B');
        // Header
        $w = array(70, 95);
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        if ($num_headers !== 0)
            $pdf->Ln();
        // Color and font restoration
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        // Data
        $fill = 0;
        $i = 0;
        foreach ($data as $row) {
            if ($num_headers !== 0 || $i !== 0) {
                $pdf->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
                $pdf->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            } else {
                if ($i == 0) {
                    $pdf->Cell($w[0], 6, $row[0], 'LRT', 0, 'L', $fill);
                    $pdf->Cell($w[1], 6, $row[1], 'LRT', 0, 'L', $fill);
                } else {
                    
                }
            }
            $pdf->Ln();
            $i +=1;
            $fill = !$fill;
        }
        $pdf->Cell(array_sum($w), 0, '', 'T');
    }

    //Page header
    protected function Header() {
        // Logo
        $image_file = K_PATH_IMAGES . 'logo_example.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    protected function Footer($pdf) {
        // Position at 15 mm from bottom
        $foottext = "This was report produced on " . DateTime()->format('Y-m-d H:i:s') . " at www.juturna.ca. Disclaimer: Data provided in this
report is not guaranteed to be error free. Neither the TRCA, EcoSpark nor any of their contributing
partners or funders shall be liable for any errors or omissions in the published content, or for any
actions taken in reliance thereon.";

        $pdf->SetY(-15);
        // Set font
        $pdf->SetFont('helvetica', 'I', 8);
        // Page number
        $pdf->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}
