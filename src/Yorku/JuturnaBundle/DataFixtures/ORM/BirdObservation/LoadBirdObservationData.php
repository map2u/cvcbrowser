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
use Yorku\JuturnaBundle\Entity\BirdObservation;
use Yorku\JuturnaBundle\Entity\Station;

/**
 * The LoadBirdData loads the bird parameter from a text file into a database table.
 * 
 * @author Joseph Zhao
 */
class LoadBirdObservationData implements FixtureInterface {

  /**
   * @inheritdoc
   */
  public function load(ObjectManager $manager) {
    return;
    
    
    
    $filepath = __DIR__ . '/../../../Resources/BirdObservation/family.txt';
    if (file_exists($filepath)) {
      $file = @fopen($filepath, "r");
      while (!feof($file)) {
        $help = trim(str_ireplace("\n", "", fgets($file)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp = explode("\t", $help);
        if ($temp[0] === null || strlen($temp[0]) === 0) {
          continue;
        }
        $srs = new Family();
        $srs->setFamilyName($temp[0]);
        $srs->setDescription($temp[1]);
        $manager->persist($srs);
      }
      $manager->flush();
      fclose($file);
    }
  }
}
