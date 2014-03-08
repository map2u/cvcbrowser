<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//	DATE	22/08/2007	13/09/2007	25/09/2007	04/10/2007	17/10/2007	26/10/2007	07/11/2007	20/11/2007	29/11/2007	12/6/2007	1/11/2008	21/01/2008	31/01/2008	2/11/2008	2/19/2008	10/03/2008	3/28/2008	
//CODE	SPECIES NAME/PERIOD	1	2	3	4	5	6	7	8	9	10	11	12	13	14	15	16	17	

namespace Yorku\JuturnaBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Yorku\JuturnaBundle\Entity\Station;
use Yorku\JuturnaBundle\Entity\BirdObservation;
use Yorku\JuturnaBundle\Entity\BreedingStatus;
use Yorku\JuturnaBundle\Entity\Species;
use Yorku\JuturnaBundle\Entity\ObservationDescription;

/**
 * The LoadSpeciesData loads the Species parameter from a text file into a database table.
 * 
 * @author Joseph Zhao
 */
class LoadStationData implements FixtureInterface {

  /**
   * @inheritdoc
   */
  public function load(ObjectManager $manager) {
    $filepath = __DIR__ . '/../../../Resources/data/Station/Station.txt';
    if (file_exists($filepath)) {
      $file = @fopen($filepath, "r");
      while (!feof($file)) {
        $help = trim(str_ireplace("\n", "", fgets($file)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp = explode(';;', $help);
        if ($temp[0] === null || strlen($temp[0]) === 0) {
          continue;
        }
        $srs = new Station();
        $srs->setCode($temp[0]);
        if (isset($temp[1]))
          $srs->setStationName($temp[1]);
        $manager->persist($srs);
        $this->loadBirdObservation(strtolower($temp[0]), $manager);
      }
      $manager->flush();
      fclose($file);
    }
  }

  private function loadBirdObservation($name, $manager) {
    $filepath2 = __DIR__ . '/../../../Resources/data/BirdObservation/'.$name.'.txt';
    // $em = $this->getDoctrine()->getManager();

    if (file_exists($filepath2)) {
      $file2 = @fopen($filepath2, "r");
      $help1 = trim(str_ireplace("\n", "", fgets($file2)));
      $help2 = trim(str_ireplace("\n", "", fgets($file2)));
      while (!feof($file2)) {
        $help = trim(str_ireplace("\n", "", fgets($file2)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp2 = explode(';;', $help);
        if ($temp2[0] === null || strlen($temp2[0]) === 0) {
          continue;
        }
        $species = $manager->getRepository("YorkuJuturnaBundle:Species")->findOneBy(array('speciesName' => $temp[1]));
        if (!$species) {
          $species = new Species();
          $species->setCode($temp2[0]);
          $species->setSpeciesName($temp2[1]);
          $manager->persist($species);
        }
//        for($i=2;$i<count($help1);$i++)
//        {
//          $srs = new BirdObservation();
//          $srs->setSpecies($species); // set the observation species
//          $this->get('logger')->debug("SpeciesName=".$species->getSpeciesName());
//          
//          
//      //    $ob= $em->getRepository("YorkuJuturnaBundle:BreedingStatus")->findOneBy(array('code'=>$temp[$i][0]));
//      //    $srs->setBreedingStatus($ob); // set the observation breeding status
//      //    $obs=[];
//      //    for($j=1;$j<count($temp[$i]);$j++)
//      //    {
//      //      $observationDescription=$em->getRepository("YorkuJuturnaBundle:ObservationDescription")->findOneBy(array('code'=>$temp[$i][$j]));
//      //      if($observationDescription)
//      //        array_push($obs,$observationDescription);
//      //    }
//          $this->get('logger')->debug("ObservationDescription=".$temp[$i]);
//          $srs->setObservationDescription($temp[$i]);
//          
//          $srs->getObservedAt($help1[$i]);
//          $manager->persist($srs);
//        };
        }
        $manager->flush();
        fclose($file2);
      }
  }

}
