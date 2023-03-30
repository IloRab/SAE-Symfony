<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Aliment;
use App\Entity\AlimentFavoris;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
class AlimentTest extends TestCase
{
    public function test_fav_alim_conv(): void
    {
        $uid = 1;
        $alim_code = 1000;

        $aliment = new Aliment();
        $aliment->setAlimCode($alim_code);

        $alim_fav = $aliment->convert_to_fav($uid);

        $this->assertEquals($alim_fav->getIdentifiant_User(), $uid);
        $this->assertEquals($alim_fav->getAlimCode(), $alim_code);
    }

    // Partitions:
    /** 
     * Null n'est pas authorisé
     * Vide
     * 1 aliment
     * 1+ aliment
    **/
    public function test_fav_alim_conv_arr(): void
    {
        //vide
        $this->assertEmpty(Aliment::convert_all_to_fav(array(), 1));


        $ar = array();
        $aliment = new Aliment();
        $aliment->setAlimCode(0);
        $ar[] = $aliment;

        //1 seul elements
        $one_alim = Aliment::convert_all_to_fav($ar, 1);

        $this->assertEquals(count($one_alim), 1);
        $this->assertEquals($one_alim[0]->getAlimCode(), 0);
        $this->assertEquals($one_alim[0]->getIdentifiant_User(), 1);

        //Plusieurs elements 
        $ar1 = array();
        $cmpt=0;
        while($cmpt<10){
            $all= new Aliment();
            $all->setAlimCode($cmpt);
            $ar1[]=$all;
            $cmpt=$cmpt + 1;
        }

        $alimentfav = Aliment::convert_all_to_fav($ar1, 1);

        $this->assertEquals(count($alimentfav), 10);
        $cmpt=0;
        while($cmpt<10){
            $this->assertEquals($alimentfav[$cmpt]->getAlimCode(), $cmpt);
            $this->assertEquals($alimentfav[$cmpt]->getIdentifiant_User(), 1);
            $cmpt=$cmpt + 1;
        }
    }
}
