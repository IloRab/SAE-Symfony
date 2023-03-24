<?php

namespace App\Repository\db_requests;

use App\Entity\AlimentFavoris;

use Doctrine\ORM\EntityManagerInterface;

class AlimentFavSaver{

    private $statement;

    public function __construct(EntityManagerInterface $em)
    {
        $this->statement = $em->getConnection()->prepare('CALL ajout_alimfav(:id_user, :code_aliment)');
    }

    public function save(AlimentFavoris $af){

        $id_usr =  $af->getIdentifiant_User();
        $code_alim = $af->getAlimCode();

        $this->statement->bindValue('id_user', $id_usr);
        $this->statement->bindValue('code_aliment', $code_alim);

        $this->statement->executeStatement();
    }

}
