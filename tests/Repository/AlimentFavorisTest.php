<?php

namespace App\Tests\Repository;
// use App\Tests\Entity\Aliment;
// use App\Tests\Repository\ManagerRegistry;
// use App\Tests\Repository\EntityManagerInterface;

use App\Entity\AlimentFavoris;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;

use PHPUnit\Framework\TestCase;

use Doctrine\DBAL\Statement;

use App\Repository\AlimentFavorisRepository;

class AlimentFavorisTest extends TestCase
{
    public function test_saves(): void   
    {

        $managerRegistry = $this->createMock(ManagerRegistry::class);

        $entityManagerInterface = $this->createMock(EntityManagerInterface::class);
        $connection = $this->createMock(Connection::class);
        $statement = $this->createMock(Statement::class);

        $aliment_fav = $this->createMock(AlimentFavoris::class);

        $entityManagerInterface
            -> method('getConnection')
            -> willReturn($connection);

        $connection
            -> method('prepare')
            // -> expects($this-> once())
            -> with('CALL ajout_alimfav(:id_user, :code_aliment)')
            -> willReturn($statement);

        $repo = new AlimentFavorisRepository($entityManagerInterface,$managerRegistry);


        // Tester save avec l'aliment mocké
        $repo
            ->method('save')
            ->with($aliment_fav)
            ->willReturn(true);

        // null
        $repo
            ->method('save')
            ->with(null)
            ->willReturn(false);


        //Tester save_all avec une liste vide
        $a = array();

        $repo
            ->method('save_all')
            ->with()
            ->willReturn(true);
        //Tester
    }
}
