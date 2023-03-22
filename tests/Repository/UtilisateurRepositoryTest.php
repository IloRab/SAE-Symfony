<?php

namespace App\Tests\Repository;

use PHPUnit\Framework\TestCase;

class UtilisateurRepositoryTest extends TestCase
{
    public function testSomething(): void
    {
        $entityManagerInterface = $this->createMock(EntityManagerInterface::class);
        $ManagerRegistry = $this->createMock(ManagerRegistry::class);
    }
}
