<?php

namespace App\Tests\Repository;

use PHPUnit\Framework\TestCase;

use App\Entity\AlimentFavoris;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\{Connection, Statement};

use App\Repository\AlimentFavorisRepository;

//use PHPUnit\Framework\MockObject\Builder\InvocationMocker;

class AlimentFavorisTest extends TestCase
{
    public function testSomething(): void
    {
      /*  $managerRegistry = $this->createMock(ManagerRegistry::class);

        $entityManagerInterface = $this->createMock(EntityManagerInterface::class);
        $connection = $this->createMock(Connection::class);

        $entityManagerInterface
            -> method('getConnection')
            -> willReturn($connection);

        
        $aliment_fav = $this->createMock(AlimentFavoris::class);
        $aliment_fav
           // ->expects($this->once())
            ->method("getIdentifiant_User")
            ->willReturn(1);

        $aliment_fav
            ->method("getAlimCode")
            ->willReturn(1000);
    

        $statement = $this->createMock(Statement::class);

        $statement
        ->expects($this->exactly(2))
        ->method("bindValue")
        ->withConsecutive(
            ['id_user', 1],
            ['code_aliment',1000]
          );

        $statement->expects($this->once())
            ->method('executeStatement');

        $connection
            -> method('prepare')
            -> with('CALL ajout_alimfav(:id_user, :code_aliment)')
            -> willReturn($statement);

       $repo = new AlimentFavorisRepository($entityManagerInterface,$managerRegistry);

       $repo ->save($aliment_fav);*/
    }
}
