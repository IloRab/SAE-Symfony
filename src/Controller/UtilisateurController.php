<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\UserType;
use App\Form\UtilisateurConnectionType;
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
			

        }

        return $this->render('utilisateur/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

	#[Route('/connection', name: 'app_connection')]
    function connection(Request $request, ManagerRegistry $doctrine): Response
		{
			$session = $request->getSession();

			if ($session->get('EST_CONNECTE')){
				//TODO
			}

			$form = $this->createForm(UtilisateurConnectionType::class);

			$form->handleRequest($request);
        	if (!$form->isSubmitted() || !$form->isValid()) {
            	return $this->render('utilisateur/index.html.twig', [
                	'form' => $form->createView(),
           		]);
        	}

        	$user =  $form -> getData();

			$entityManager = $doctrine->getManager();
        	// $user_information = $entityManager->getRepository(Utilisateur::class)->findOneBy(array('nom' => $user -> getNom(),'num' => $user -> getNum()));
			$user_information = $entityManager->getRepository(Utilisateur::class)->findOneBy(array('id' => $user -> getId(),'password' => $user -> getPassword()));

        	if (!$user_information){
            	return $this->render('utilisateur/index.html.twig', [
                	'form' => $form->createView(),
                	'error_message' => "Connexion impossible, utilisateur inexistant ou mot de passe invalide", 
            	]);
        	}

        	$session->set('id', $user_information->getId());
        	$session->set('EST_CONNECTE', TRUE);

        	// return $this->redirectToRoute('contacts_show');
	
		}

function deconnection()
{
	//session_start();
	//session_destroy();
	header("location: " . "index.php");
}


}
