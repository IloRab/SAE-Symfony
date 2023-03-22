<?php

namespace App\Tests\Repository;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;

class AlimentFavorisTest extends TestCase
{
    public function testSomething(): void

   
    {
        $entityManagerInterface = $this->createMock(EntityManagerInterface::class);
        $ManagerRegistry = $this->createMock(ManagerRegistry::class);
        $connection = $this->createMock(Connection::class);
        $statement = $this->createMock(Statement::class);


        $entityManagerInterface->method('getConnection')->willReturn($connection);
        $connection->method('prepare')->expects($this->once())->with('CALL ajout_alimfav(:id_user, :code_aliment')->willReturn($statement);

    }
}
