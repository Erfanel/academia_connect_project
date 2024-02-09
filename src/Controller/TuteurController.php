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



class TuteurController extends AbstractController
{
    #[IsGranted("ROLE_TUTEUR")]
    #[Route('/Tuteur/tuteurHome', name: 'tuteurHome')]
    public function TuteurHome(): Response
    {
        //Recupérer les apprenants du tuteur
        $user = $this->getUser();
        $apprenants = $user->getApprenants();

        return $this->render('main/tuteur/tuteurHome.html.twig', [
            'apprenants' => $apprenants
        ]);
    }

    #[IsGranted("ROLE_TUTEUR")]
    #[Route('/Tuteur/{apprenantId}/', name: 'tuteurApprenant')]
    public function TuteurApprenant($apprenantId, EntityManagerInterface $entityManager): Response
    {
        //Recupérer le repo de l'apprenant {id}
        $apprenantRepo = $entityManager->getRepository(Utilisateur::class);
        //extraire l'ID et les apprenants de l'apprenant
        $apprenant = $apprenantRepo->find($apprenantId);
        $formation = $apprenant->getFormationSuivie();
        $matieres = $formation->getMatieres();

        return $this->render('main/tuteur/tuteurMatiere.html.twig', [
            'apprenant' => $apprenant,
            'matieres' => $matieres
        ]);
    }

    #[IsGranted("ROLE_TUTEUR")]
    #[Route('/Tuteur/{apprenantId}/Matiere/{matiereId}', name: 'tuteurMatiere')]
    public function TuteurMatiere($apprenantId, $matiereId, EntityManagerInterface $entityManager): Response
    {
        //Recupérer le repo de la matière selectionnée {id}
        $matiereRepo = $entityManager->getRepository(Matiere::class);
        //extraire l'ID et les notes de la matière
        $matiere = $matiereRepo->find($matiereId);

        return $this->render('main/tuteur/tuteurMatiere.html.twig', [
            'matiere' => $matiere
        ]);
    }

    #[IsGranted("ROLE_TUTEUR")]
    #[Route('/Tuteur/{apprenantId}/Notes/{matiereId}', name: 'tuteurNotes')]
    public function TuteurNotes($matiereId, $apprenantId, EntityManagerInterface $entityManager): Response
    {
        //Recupérer le repo de la matière selectionnée {id}
        $matiereRepo = $entityManager->getRepository(Matiere::class);
        //extraire l'ID et les notes de la matière
        $matiere = $matiereRepo->find($matiereId);

        $apprenantRepo = $entityManager->getRepository(Utilisateur::class);
        //extraire l'ID et les apprenants de l'apprenant
        $apprenant = $apprenantRepo->find($apprenantId);

        return $this->render('main/tuteur/tuteurNotes.html.twig', [
            'matiere' => $matiere
            ,'apprenant' => $apprenant
            
        ]);
    }

    #[IsGranted("ROLE_TUTEUR")]
    #[Route('/Tuteur/{apprenantId}/Programme/{matiereId}', name: 'tuteurProgramme')]
    public function TuteurProgramme($matiereId,EntityManagerInterface $entityManager): Response
    {
        //Recupérer le repo de la matière selectionnée {id}
        $matiereRepo = $entityManager->getRepository(Matiere::class);
        //extraire l'ID et les notes de la matière
        $matiere = $matiereRepo->find($matiereId);

        return $this->render('main/tuteur/tuteurProgramme.html.twig', [
            'matiere' => $matiere
        ]);
    }
}
