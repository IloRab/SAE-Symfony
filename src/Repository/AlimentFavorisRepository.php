<?php

namespace App\Repository;

use App\Entity\AlimentFavoris;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;

use Doctrine\DBAL\Driver\PDO\Exception;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


use App\Repository\db_requests\AlimentFavSaver;


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
    private $alimFavSaver;
    private $connection;
    private $score_sante_min;
    private $score_sante_max;
    private $score_sante_median;

    private $score_sante_distribution;

    private $aliments_fav_annuel;

    public function __construct(EntityManagerInterface $em, ManagerRegistry $registry)
    {

        parent::__construct($registry, AlimentFavoris::class);

        $this->connection = $em->getConnection();
        $this->alimFavSaver = new AlimentFavSaver($em);

        $this->score_sante_min = $this->connection->prepare("SELECT MIN(Score) FROM score_sante");
        $this->score_sante_max = $this->connection->prepare("SELECT MAX(Score) FROM score_sante");
        $this->score_sante_avg = $this->connection->prepare("SELECT ROUND(AVG(Score)) FROM score_sante");

        $this->score_sante_distribution = $this->connection->prepare("select ROUND(score) AS score_sante, COUNT(score) as effectif from score_sante group by 1 ORDER BY score_sante;");

        $this->aliments_fav_annuel = $this->connection->prepare("SELECT Af.Annee, A.alim_nom_fr,A.alim_grp_nom_fr,A.alim_ssgrp_nom_fr FROM aliment A,alimfavori Af WHERE A.alim_code = Af.alim_code;");

    }

    /**
     * Enregistre un aliment en tant que favori pour un utilisateur.
     *
     */
    function save(AlimentFavoris $af): bool
    {
        try{
            $this->alimFavSaver->save($af);
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

    function get_alims_stats() : array{

        $rep["min"] = $this->score_sante_min->executeQuery()->fetchOne();
        $rep["median"] = $this->score_sante_avg->executeQuery()->fetchOne();
        $rep["max"] = $this->score_sante_max->executeQuery()->fetchOne();
        
        return $rep;
    }

    function get_alims_distr() : array{
       return $this->score_sante_distribution->executeQuery()->fetchAll();
    }
}
