<?php

namespace App\Repository;

use App\Entity\AlimentFavoris;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;

use Doctrine\DBAL\Driver\PDO\Exception;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

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
    

    public function __construct(EntityManagerInterface $em, ManagerRegistry $registry)
    {
        parent::__construct($registry, AlimentFavoris::class);

        $this->statement = $em->getConnection()->prepare('CALL ajout_alimfav(:id_user, :code_aliment)');
    }

    /**
     * Enregistre un aliment en tant que favori pour un utilisateur.
     *
     * @param int $userId L'ID de l'utilisateur pour lequel enregistrer le favori.
     * @param string $codeAliment Le code de l'aliment à enregistrer en tant que favori.
     */
    function save(AlimentFavoris $af): bool
    {
        try{
            $id_usr =  $af->getIdentifiant_User();
            $code_alim = $af->getAlimCode();

            $this->statement->bindValue('id_user', $id_usr);
            $this->statement->bindValue('code_aliment', $code_alim);

            $this->statement->execute();
            return true;
        } catch(UniqueConstraintViolationException  $e){
            return false;
        } catch(Exception  $e){
            return false;
        }
        
    }

    function save_all(array $aliments_fav, int $uid): bool
    {
        foreach ($aliments_fav as $fav) {
            $no_error = $this->save($fav);
            if (!$no_error)
                return false;
		}
        return true;
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
