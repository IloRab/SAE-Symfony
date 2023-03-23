<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\{Aliment, Utilisateur};
use App\Form\{UserType, AlimentsFavorisType, UtilisateurConnectionType};
use App\Repository\{AlimentFavorisRepository, UtilisateurRepository, UtilisateurConnecteRepository};

use Symfony\Component\HttpFoundation\JsonResponse;

class UtilisateurController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request, UtilisateurRepository $user_repo): Response
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

		$u =  $form -> getData();
		$user_repo->save($u);

		return $this->redirectToRoute('app_connection');

    }

	#[Route('/connection', name: 'app_connection')]
    function connection(Request $request, UtilisateurConnecteRepository $user_repo): Response
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

			// $entityManager = $doctrine->getManager();
        	// // $user_information = $entityManager->getRepository(Utilisateur::class)->findOneBy(array('nom' => $user -> getNom(),'num' => $user -> getNum()));
			// $user_information = $entityManager->getRepository(Utilisateur::class)->findOneBy(array('id' => $user -> getId(),'password' => $user -> getPassword()));

        	if (!$user_repo->verif_indentifiants($user)){
            	return $this->render('utilisateur/index.html.twig', [
                	'form' => $form->createView(),
					'auth_title' => "Connection",
					'auth_msg' => "S'inscrire",
					'auth_url' => "/inscription",
                	'error_msg' => "Connexion impossible, utilisateur inexistant ou mot de passe invalide", 
            	]);
        	}

        	$session->set('id', $user->getId());
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

		$uid = $session->get('id');
		$data = $form->getData();

		$aliments_fav = Aliment::convert_all_to_fav($data, $uid);

		$no_error = $alim_repo->save_all($aliments_fav,$uid);
		if (!$no_error){
			return $this->render('utilisateur/sante.html.twig', [
				'form' => $form->createView(),
				'auth_title' => "Sondage Santé",
				'error_msg' => "Un de ces aliments a déjà été selectionné comme favoris. "
				]);
		}
		
		

		return $this->redirectToRoute('recap');
    }

	#[Route('/recap', name: 'recap')]                                                                                                                                                                                                                                                                                                         
    public function recap(Request $request,ManagerRegistry $doctrine){

		return $this->render('utilisateur/recap.html.twig');
	}


	// Réponses de recap
	
	#[Route('/recap_user', name: 'recap_user')]                                                                                                                                                                                                                                                                                                         
    public function recap_user(Request $request,ManagerRegistry $doctrine){
		$session = $request->getSession();

		if (!$session->get('EST_CONNECTE')){
			return $this->redirectToRoute('app_connection');
		}

		$data_tmp = array(
			array("Eau minérale Abatilles, embouteillée, non gazeuse, faiblement minéralisée (Arcachon, 33)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Aix-les-Bains, embouteillée, non gazeuse, faiblement minéralisée (Aix-les-Bains, 73)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Aizac, embouteillée, gazeuse, faiblement minéralisée (Aizac, 07)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Amanda, embouteillée, non gazeuse, fortement minéralisée (St-Amand, 59)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Arcens, embouteillée, gazeuse, moyennement minéralisée (Arcens, 07)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Ardesy, embouteillée, gazeuse, fortement minéralisée (Ardes, 63)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Celtic, embouteillée, gazeuse ou non gazeuse, très faiblement minéralisée (Niederbronn, 67)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Chambon, embouteillée, non gazeuse, faiblement minéralisée (Chambon, 45)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Chantemerle, embouteillée, non gazeuse, faiblement minéralisée (Le Pestrin, 07)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Chateauneuf, embouteillée, gazeuse, fortement minéralisée (Chateauneuf, 63)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Chateldon, embouteillée, gazeuse, fortement minéralisée (Chateldon, 63)", "eaux et autres boissons", "eaux")
		);

		$user = [
			'score-sante' => 12,
			'aliments-fav' => $data_tmp
		];

		return new JsonResponse($user);
	}

	#[Route('/recap_global', name: 'recap_global')]                                                                                                                                                                                                                                                                                                         
    public function recap_global(Request $request,ManagerRegistry $doctrine)
	{

		$data_tmp = array(
			array("Eau minérale Abatilles, embouteillée, non gazeuse, faiblement minéralisée (Arcachon, 33)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Aix-les-Bains, embouteillée, non gazeuse, faiblement minéralisée (Aix-les-Bains, 73)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Aizac, embouteillée, gazeuse, faiblement minéralisée (Aizac, 07)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Amanda, embouteillée, non gazeuse, fortement minéralisée (St-Amand, 59)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Arcens, embouteillée, gazeuse, moyennement minéralisée (Arcens, 07)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Ardesy, embouteillée, gazeuse, fortement minéralisée (Ardes, 63)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Celtic, embouteillée, gazeuse ou non gazeuse, très faiblement minéralisée (Niederbronn, 67)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Chambon, embouteillée, non gazeuse, faiblement minéralisée (Chambon, 45)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Chantemerle, embouteillée, non gazeuse, faiblement minéralisée (Le Pestrin, 07)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Chateauneuf, embouteillée, gazeuse, fortement minéralisée (Chateauneuf, 63)", "eaux et autres boissons", "eaux"),
			array("Eau minérale Chateldon, embouteillée, gazeuse, fortement minéralisée (Chateldon, 63)", "eaux et autres boissons", "eaux")
		);

		$tmp_distribution = array(
			12, 16, 9, 5, 18, 9, 17, 14, 8, 18,
			12, 10, 7, 17, 13, 15, 8, 11, 16, 6,
			12, 16, 9, 5, 18, 9, 17, 14, 8, 18
		);
		
		$global = [
			'score-sante-stats' => [
				'min' => 1,
				'median' => 12,
				'max' => 20
			],
			'score-sante-distribution' => $tmp_distribution,
			'aliments-fav-annuel' => [
				[
					'année' => 2023,
					'aliments' => $data_tmp
				],
				[
					'année' => 2022,
					'aliments' => $data_tmp
				]
			]
		];

		return new JsonResponse($global);
	}


}
