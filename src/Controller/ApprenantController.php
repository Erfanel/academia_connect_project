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
#[Route('/Apprenant/apprenantHome', name: 'apprenantHome')]
    public function ApprenantHome(): Response
    {
        $user = $this->getUser();
        $formation = $user->getFormationSuivie();
        $matieres = $formation->getMatieres();

        return $this->render('main/apprenant/apprenantHome.html.twig', [
            'formation' => $formation,
            'matieres' => $matieres
        ]);
    }

    #[IsGranted("ROLE_APPRENANT")]
    #[Route('/Apprenant/programme/{matiereId}', name: 'apprenantProgramme')]
    public function ApprenantProgramme($matiereId, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        //Recupérer le repo de la matière selectionnée {id}
        $matiereRepo = $entityManager->getRepository(Matiere::class);
        //extraire l'ID et les notes de la matière
        $matiere = $matiereRepo->find($matiereId);

        return $this->render('main/apprenant/apprenantProgramme.html.twig', [
            'matiere' => $matiere,
            'user' => $user
        ]);
    }

    #[IsGranted("ROLE_APPRENANT")]
    #[Route('/Apprenant/notes/{matiereId}', name: 'apprenantNotes')]
    public function ApprenantNotes($matiereId, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        //Recupérer le repo de la matière selectionnée {id}
        $matiereRepo = $entityManager->getRepository(Matiere::class);
        //extraire l'ID et les notes de la matière
        $matiere = $matiereRepo->find($matiereId);

        return $this->render('main/apprenant/apprenantNotes.html.twig', [
            'matiere' => $matiere,
            'user' => $user
        ]);
    }
}
