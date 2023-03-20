<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    #[Route('/accueil.html')]
    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        return $this->render('site/index.html.twig');
    }

    #[Route('/presentation.html')]
    #[Route('/presentation', name: 'presentation')]
    public function presentation(): Response
    {
        return $this->render('site/pres.html.twig');
    }

    #[Route('/actualites.html')]
    #[Route('/actualites', name: 'actualites')]
    public function actualites(): Response
    {
        return $this->render('site/actu.html.twig');
    }

    #[Route('/tourisme_et_transport.html')]
    #[Route('/tourisme_et_transport', name: 'tourisme_et_transport')]
    public function tourisme_et_transport(): Response
    {
        return $this->render('site/tourisme.html.twig');
    }
}
