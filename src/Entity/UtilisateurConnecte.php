<?php

namespace App\Entity;

use App\Repository\UtilisateurConnecteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurConnecteRepository::class)]
class UtilisateurConnecte
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    // #[ORM\Column(length: 100)]
    // private ?string $token = null;

    #[ORM\Column]
    private String $password;

    public function setId(int $i){
        $this->id = $i;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassword() : String{
        return $this->password;
    }

    public function setPassword(String $i){
        $this->password =$i;
    }

    // public function getToken(): ?string
    // {
    //     return $this->token;
    // }

    // public function setToken(string $token): self
    // {
    //     $this->token = $token;

    //     return $this;
    // }
}
