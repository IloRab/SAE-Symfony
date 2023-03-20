<?php

namespace App\Entity;
use \Datetime;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

/** @UniqueEntity(
  * fields={"id"},
  * errorPath="madbit",
  * message="Vous vous êtes déjà inscrit avec ce numero d'Admninistre"
  *)
  */

  
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[Table(name: 'utilisateur')]
class Utilisateur
{

    #[ORM\Id]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private String $password;

    #[ORM\Column]
    private String $nom;

    #[ORM\Column]
    private String $prenom;

    #[ORM\Column(type: "date")]
    private Datetime $naissance;

    #[ORM\Column]
    private int $c_postal;

    #[ORM\Column(name: "telephone")]
    private String $num_tel;

    #[ORM\Column]
    private String $ville;

    #[ORM\Column(name: "adresse")]
    private String $adresse;

    public function setId(int $i){
        $this->id = $i;
    }

    public function getId() : int{
        return $this->id;
    }

    public function getPassword() : String{
        return $this->password;
    }

    public function setPassword(String $i){
        $this->password =$i;
    }

    public function setNom(String $i){
        $this->nom = $i;
    }

    public function getNom() : String{
        return $this->nom;
    }

    public function setPrenom(String $i){
        $this->prenom = $i;
    }

    public function getPrenom() : String{
        return $this->prenom;
    }

    public function setVille(String $i){
        $this->ville = $i;
    }

    public function getVille() : String{
        return $this->ville;
    }

    public function setAdresse(String $i){
        $this->adresse = $i;
    }

    public function getAdresse() : String{
        return $this->adresse;
    }


    public function setCpostal(int $i){
        $this->c_postal = $i;
    }

    public function getCpostal() : int{
        return $this->c_postal;
    }

    public function setNumtel(String $i){
        $this->num_tel = $i;
    }

    public function getNumtel() : ?String{
        return $this->num_tel;
    }


    public function setNaissance(DateTime $n){
        $this -> naissance = $n;
    }

    public function getNaissance() : DateTime{
        return $this -> naissance;
    }


}
