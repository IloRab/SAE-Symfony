<?php

namespace App\Tests\Repository;

use App\Entity\AlimentFavoris;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;

class UtilisateurRepositoryTest extends TestCase
{
    public function testSomething(): void
    {
        $entityManagerInterface = $this->createMock(EntityManagerInterface::class);
        $ManagerRegistry = $this->createMock(ManagerRegistry::class);
    }
}
