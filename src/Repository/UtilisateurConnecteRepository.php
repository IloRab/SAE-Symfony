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

    private $connection;
    private $score_stm;
    private $alims_stm;

    public function __construct(EntityManagerInterface $em, ManagerRegistry $registry)
    {
        parent::__construct($registry, UtilisateurConnecte::class);
        $this->em = $em;

        $this->connection = $this->em->getConnection();
        $this->alims_stm = $this->connection->prepare("SELECT A.alim_nom_fr, A.alim_grp_nom_fr, A.alim_ssgrp_nom_fr 
        FROM aliment A 
        WHERE A.alim_code IN (
            SELECT alim_code 
            FROM alimfavori 
            WHERE Identifiant_User = :Id 
            AND Annee= YEAR(SYSDATE())
        )");
        $this->score_stm = $this->connection->prepare('SELECT Score 
        FROM score_sante 
        WHERE IdentifiantUser = :Id;');
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

    public function get_score(UtilisateurConnecte $user){
        $id = $user->getId();
        $this->score_stm->bindParam(':Id', $id);

        return $this->score_stm->executeQuery()->fetchOne();
        
    }

    public function get_alims(UtilisateurConnecte $user) {
        $id = $user->getId();
        $this->alims_stm->bindParam(':Id', $id);
 
        return $this->alims_stm->executeQuery()->fetchAllAssociative();
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
