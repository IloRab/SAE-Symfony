<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Aliment;
use App\Entity\AlimentFavoris;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
class AlimentTest extends TestCase
{
    public function test_array_convertion(): void
    {
        $uid = 1;
        $alim_code = 1000;

        $aliment = $this->createMock(Aliment::class);
        $aliment->method('convert_to_fav')->willReturn(new AlimentFavoris($uid, $alim_code));

        

    }
}