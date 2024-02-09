<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Formation;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ApprenantController extends AbstractController
{
    #[IsGranted("ROLE_APPRENANT")]
    #[Route('/homeApprenant', name: 'homeApprenant')]
    public function homeApprenant(): Response
    {
        $user = $this->getUser();
        $formation = $user->getFormationSuivie();
        $matieres = $formation->getMatieres();

        return $this->render('main/homeApprenant.html.twig', [
            'formation' => $formation,
            'matieres' => $matieres
        ]);
    }
}
