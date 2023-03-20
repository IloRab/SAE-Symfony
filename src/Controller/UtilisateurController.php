<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\UserType;
use App\Entity\Utilisateur;


class UtilisateurController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request, ManagerRegistry $doctrine): Response
    {


//        $new_user = new Utilisateur();

        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
		//	var_dump($new_user);
			$entityManager = $doctrine->getManager();

			// tell Doctrine you want to (eventually) save the Product (no queries yet)
			$u =  $form -> getData();
			$entityManager->persist($u);

			// actually executes the queries (i.e. the INSERT query)
			$entityManager->flush();
			
			//var_dump($new_user -> getId());

            // ... perform some action, such as saving the task to the database
			//  wtf mon capslock marche pas sur ton pc
			//  Quand je tapper en capslock rien ne s'affiche

        }

        return $this->render('utilisateur/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

	#[Route('/connection', name: 'app_connection')]
    function connection(Request $request, ManagerRegistry $doctrine): Response
		{
			


	
		}


// function inscription()
// {

// 	$admin_id = isset($_POST['admin_id']) ? ($_POST['admin_id']) : '';
// 	$nom = isset($_POST['nom']) ? ($_POST['nom']) : '';
// 	$prenom = isset($_POST['prenom']) ? ($_POST['prenom']) : '';
// 	$rue = isset($_POST['rue']) ? ($_POST['rue']) : '';
// 	$ville = isset($_POST['ville']) ? ($_POST['ville']) : '';
// 	$c_postal= isset($_POST['c_postal']) ? ($_POST['c_postal']) : '';
// 	$num_tel= isset($_POST['num_tel']) ? ($_POST['num_tel']) : '';
// 	$password = isset($_POST['password']) ? ($_POST['password']) : '';
// 	$msg = '';
	
// 	require('modele/utilisateurBD.php');

// 	if (count($_POST) == 0){
// 	  require("./vue/utilisateur/connexion.tpl");
// 	  return;
// 	}

// 	if (!verif_ident($admin_id, $username, $password, $profil)) {
// 		$_SESSION['profil'] = array();
// 		$msg = "erreur de saisie";
// 		require("./vue/utilisateur/connexion.tpl");
// 		return;
// 	}

// 	$_SESSION['profil'] = $profil;
// 	echo "HAHAHAHAHAHA";
// 	//$url = "index.php?controle=user&action=accueil";
// 	//header("Location:" . $url);
	
// }

function deconnection()
{
	//session_start();
	//session_destroy();
	header("location: " . "index.php");
}


}
