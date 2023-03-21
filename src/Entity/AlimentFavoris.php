<?php

namespace App\Entity;

use App\Repository\AlimentFavorisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlimentFavorisRepository::class)]
class AlimentFavoris
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $Identifiant_User = null;

    #[ORM\Id]
    #[ORM\Column]
    private ?int $alim_code = null;

    public function __construct(int $id_user, int $alim_code){
        $this->Identifiant_User = $id_user;
        $this->alim_code = $alim_code;
    }

    public function getIdentifiant_User(): ?int
    {
        return $this->Identifiant_User;
    }

    public function getAlimCode(): ?int
    {
        return $this->alim_code;
    }

    public function setAlimCode(int $alim_code): self
    {
        $this->alim_code = $alim_code;

        return $this;
    }
}
