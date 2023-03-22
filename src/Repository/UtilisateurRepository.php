<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 *
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    private $connection;
    private $save_user_statement;

    public function __construct(EntityManagerInterface $entityManage, ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);

        $this->connection = $entityManage->getConnection();
        $this->save_user_statement = $this->connection->prepare('CALL ajout_user(:Id, :mdp, :Nom, :Prenom, :DateOfBirth, :CodePostale, :Tel, :City, :Address
        )');
    }

    public function save(Utilisateur $user): void
    {
        $id = $user->getId();
        $password = $user->getPassword();
        $nom = $user->getNom();
        $prenom = $user->getPrenom();
        $dateOfBirth = $user->getNaissance()->format('Y-m-d');
        $codePostale = $user->getCpostal();
        $tel = $user->getNumtel();
        $city = $user->getVille();
        $address = $user->getAdresse();
        
        $this->save_user_statement->bindParam(':Id', $id);
        $this->save_user_statement->bindParam(':mdp', $password);
        $this->save_user_statement->bindParam(':Nom', $nom);
        $this->save_user_statement->bindParam(':Prenom', $prenom);
        $this->save_user_statement->bindParam(':DateOfBirth', $dateOfBirth);
        $this->save_user_statement->bindParam(':CodePostale', $codePostale);
        $this->save_user_statement->bindParam(':Tel', $tel);
        $this->save_user_statement->bindParam(':City', $city);
        $this->save_user_statement->bindParam(':Address', $address);

        // Execute the statement
        $this->save_user_statement->execute();
    }

    public function remove(Utilisateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    

    // public function findContactsById($id)
    // {
    //     // SELECT nom, prenom, email from contact c, utilisateur u where c.id_nom = :id and c.id_contact = u.id_nom limit 0,30
    //     $qb = $this->createQueryBuilder('u')
    //         ->select('u.nom', 'u.prenom', 'u.email')
    //         ->innerJoin(Contact::class, 'c')
    //         ->where('c.id_nom = :id')
    //         ->andWhere('c.id_contact = u.id_nom')
    //         ->setParameter('id', $id)
    //         ->setMaxResults(30);

    //     return $qb->getQuery()->getResult();
    // }

//    /**
//     * @return Utilisateur[] Returns an array of Utilisateur objects
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

//    public function findOneBySomeField($value): ?Utilisateur
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
