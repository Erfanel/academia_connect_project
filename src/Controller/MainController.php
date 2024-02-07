<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;



class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('app_login');
    }

    // #[IsGranted("ROLE_ADMIN")]
    #[Route('/homeFormateur', name: 'homeFormateur')]
    public function homeFormateur(): Response
    {
        return $this->render('main/homeFormateur.html.twig');
    }

    // #[IsGranted("ROLE_ADMIN")]
    #[Route('/homeTuteur', name: 'homeTuteur')]
    public function homeTuteur(): Response
    {
        return $this->render('main/homeTuteur.html.twig');
    }

    // #[IsGranted("ROLE_ADMIN")]
    #[Route('/homeApprenant', name: 'homeApprenant')]
    public function homeApprenant(): Response
    {
        return $this->render('main/homeApprenant.html.twig');
    }
}
