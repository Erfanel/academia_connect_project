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

    #[IsGranted("ROLE_FORMATEUR")]
    #[Route('/homeFormateur', name: 'homeFormateur')]
    public function homeFormateur(): Response
    {
        $user = $this->getUser();
        $matieres = $user->getMatiereEnseignee();
        foreach ($matieres as $matiere) {
            $formations = $matiere->getFormation();
        } 



        return $this->render('main/homeFormateur.html.twig', [
            'matieres' => $matieres,
            'formations' => $formations
        ]);
    }

    #[IsGranted("ROLE_TUTEUR")]
    #[Route('/homeTuteur', name: 'homeTuteur')]
    public function homeTuteur(): Response
    {
        return $this->render('main/homeTuteur.html.twig');
    }

    #[IsGranted("ROLE_APPRENANT")]
    #[Route('/homeApprenant', name: 'homeApprenant')]
    public function homeApprenant(): Response
    {
    
        return $this->render('main/homeApprenant.html.twig');
    }

    #[Route('/homeAll', name: 'homeAll')]
    public function homeAll(): Response
    {
        if( $this->isGranted('ROLE_FORMATEUR') ){
            return $this->redirectToRoute('homeFormateur');
        }
        if( $this->isGranted('ROLE_TUTEUR') ){
            return $this->redirectToRoute('homeTuteur');
        }
        if( $this->isGranted('ROLE_APPRENANT') ){
            return $this->redirectToRoute('homeApprenant');
        }
        return $this->redirectToRoute('error');
    }
}
