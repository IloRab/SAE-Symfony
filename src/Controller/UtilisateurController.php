<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\UserType;
use App\Entity\Aliment;
use App\Form\AlimentsFavorisType;
use App\Form\UtilisateurConnectionType;
use App\Entity\Utilisateur;
use App\Repository\AlimentFavorisRepository;

class UtilisateurController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request, ManagerRegistry $doctrine): Response
    {
		$session = $request->getSession();
		if ($session->get('EST_CONNECTE')){
			return $this->redirectToRoute('sondage');
		}

        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
			return $this->render('utilisateur/index.html.twig', [
				'form' => $form->createView(),
				'auth_title' => "Inscription",
				'auth_msg' => "Se connecter",
				'auth_url' => "/connection",
			]);
		}

		$entityManager = $doctrine->getManager();

		$u =  $form -> getData();
		$entityManager->persist($u);
		$entityManager->flush();

		return $this->redirectToRoute('app_connection');

    }

	#[Route('/connection', name: 'app_connection')]
    function connection(Request $request, ManagerRegistry $doctrine): Response
		{
			$session = $request->getSession();

			if ($session->get('EST_CONNECTE')){
				return $this->redirectToRoute('sondage');
			}

			$form = $this->createForm(UtilisateurConnectionType::class);

			$form->handleRequest($request);
        	if (!$form->isSubmitted() || !$form->isValid()) {
            	return $this->render('utilisateur/index.html.twig', [
                	'form' => $form->createView(),
					'auth_title' => "Connection",
					'auth_msg' => "S'inscrire",
					'auth_url' => "/inscription",
           		]);
        	}

        	$user =  $form -> getData();

			$entityManager = $doctrine->getManager();
        	// $user_information = $entityManager->getRepository(Utilisateur::class)->findOneBy(array('nom' => $user -> getNom(),'num' => $user -> getNum()));
			$user_information = $entityManager->getRepository(Utilisateur::class)->findOneBy(array('id' => $user -> getId(),'password' => $user -> getPassword()));

        	if (!$user_information){
            	return $this->render('utilisateur/index.html.twig', [
                	'form' => $form->createView(),
					'auth_title' => "Connection",
					'auth_msg' => "S'inscrire",
					'auth_url' => "/inscription",
                	'error_message' => "Connexion impossible, utilisateur inexistant ou mot de passe invalide", 
            	]);
        	}

        	$session->set('id', $user_information->getId());
        	$session->set('EST_CONNECTE', TRUE);

        	return $this->redirectToRoute('sondage');
	
		}

	#[Route('/sondage', name: 'sondage')]                                                                                                                                                                                                                                                                                                         
    public function sondage(Request $request, AlimentFavorisRepository $alim_repo)
    {
		$session = $request->getSession();

		if (!$session->get('EST_CONNECTE')){
			return $this->redirectToRoute('app_connection');
		}

		$form = $this->createForm(AlimentsFavorisType::class);

		$form->handleRequest($request);
		if (!$form->isSubmitted() || !$form->isValid()) {
			return $this->render('utilisateur/sante.html.twig', [
				'form' => $form->createView(),
				'auth_title' => "Sondage Santé",
			   ]);
		}

		$aliments_fav = $form->getData();
		foreach ($aliments_fav as $fav) {
			$alim_repo->save_alim_favoris($fav->to_alim_fav($session->get('id')));
		}

		return $this->redirectToRoute('recap');
    }

	#[Route('/recap', name: 'recap')]                                                                                                                                                                                                                                                                                                         
    public function recap(Request $request,ManagerRegistry $doctrine){

		
	}


}
