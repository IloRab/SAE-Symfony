<?php

namespace App\Repository;

use App\Entity\AlimentFavoris;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\DBAL\Connection;

/**
 * @extends ServiceEntityRepository<AlimentFavoris>
 *
 * @method AlimentFavoris|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlimentFavoris|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlimentFavoris[]    findAll()
 * @method AlimentFavoris[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlimentFavorisRepository extends ServiceEntityRepository
{
    private $statement;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlimentFavoris::class);

        $connection = $this->getEntityManager()->getConnection();
        $this->statement = $connection->prepare('CALL ajout_alimfav(:id_user, :code_aliment)');
    }

    public function save(AlimentFavoris $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AlimentFavoris $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     * Enregistre un aliment en tant que favori pour un utilisateur.
     *
     * @param int $userId L'ID de l'utilisateur pour lequel enregistrer le favori.
     * @param string $codeAliment Le code de l'aliment à enregistrer en tant que favori.
     */
    function save_alim_favoris(AlimentFavoris $af): void
    {
        $statement->bindValue('id_user', $af->getIdentifiant_User());
        $statement->bindValue('code_aliment', $af->getAlimCode());

        $statement->execute();
    }
//    /**
//     * @return AlimentFavoris[] Returns an array of AlimentFavoris objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AlimentFavoris
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
