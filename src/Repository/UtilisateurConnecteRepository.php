<?php

namespace App\Repository;

use App\Entity\UtilisateurConnecte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<UtilisateurConnecte>
 *
 * @method UtilisateurConnecte|null find($id, $lockMode = null, $lockVersion = null)
 * @method UtilisateurConnecte|null findOneBy(array $criteria, array $orderBy = null)
 * @method UtilisateurConnecte[]    findAll()
 * @method UtilisateurConnecte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurConnecteRepository extends ServiceEntityRepository
{
    private $em;
    public function __construct(EntityManagerInterface $em, ManagerRegistry $registry)
    {
        parent::__construct($registry, UtilisateurConnecte::class);
        $this->em = $em;
    }
    
    public function verif_indentifiants(UtilisateurConnecte $user) : bool {
 
        $em = $this->em;

        $sql = 'SELECT verif_pwd(:id, :pwd) AS est_vrai';

        $rsm = new ResultSetMappingBuilder($em);
        $rsm->addScalarResult('est_vrai', 'result', 'boolean');

        $query = $em->createNativeQuery($sql, $rsm);

        $id =  $user->getId();
        $pwd = $user->getPassword();

        $query->setParameter('id', $id);
        $query->setParameter('pwd', $pwd);

        $res =  $query->getSingleScalarResult();
        return $res;
    }

//    /**
//     * @return UtilisateurConnecte[] Returns an array of UtilisateurConnecte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UtilisateurConnecte
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
