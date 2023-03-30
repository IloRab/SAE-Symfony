<?php

namespace App\Entity;

use App\Repository\AlimentsRepository;
use Doctrine\ORM\Mapping as ORM;

use Ds\Set;

#[ORM\Entity(repositoryClass: AlimentsRepository::class)]
class Aliment
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $alim_code = null;

    #[ORM\Column(length: 50)]
    private ?string $alim_nom_fr = null;

    #[ORM\Column(length: 50)]
    private ?string $alim_grp_nom_fr = null;

    #[ORM\Column(length: 50)]
    private ?string $alim_ssgrp_nom_fr = null;

    #[ORM\Column(length: 50)]
    private ?string $alim_ssssgrp_nom_fr = null;


    public function getAlimCode(): ?int
    {
        return $this->alim_code;
    }

    public function setAlimCode(int $alim_code): self
    {
        $this->alim_code = $alim_code;

        return $this;
    }

    public function getAlimNomFr(): ?string
    {
        return $this->alim_nom_fr;
    }

    public function setAlimNomFr(string $alim_nom_fr): self
    {
        $this->alim_nom_fr = $alim_nom_fr;

        return $this;
    }

    public function getAlimGrpNomFr(): ?string
    {
        return $this->alim_grp_nom_fr;
    }

    public function setAlimGrpNomFr(string $alim_grp_nom_fr): self
    {
        $this->alim_grp_nom_fr = $alim_grp_nom_fr;

        return $this;
    }

    public function getAlimSsgrpNomFr(): ?string
    {
        return $this->alim_ssgrp_nom_fr;
    }

    public function setAlimSsgrpNomFr(string $alim_ssgrp_nom_fr): self
    {
        $this->alim_ssgrp_nom_fr = $alim_ssgrp_nom_fr;

        return $this;
    }

    public function getAlimSsssgrpNomFr(): ?string
    {
        return $this->alim_ssssgrp_nom_fr;
    }

    public function setAlimSsssgrpNomFr(string $alim_ssssgrp_nom_fr): self
    {
        $this->alim_ssssgrp_nom_fr = $alim_ssssgrp_nom_fr;

        return $this;
    }

    public function convert_to_fav(int $uid) : AlimentFavoris
    {
        return new AlimentFavoris($uid, $this->alim_code);
    }

    public static function convert_all_to_fav(array $aliments, int $uid) : array {
        $ar = array();

        foreach ($aliments as $alim) {
			$ar[] = $alim->convert_to_fav($uid);
		}

        return $ar;
    }
}
