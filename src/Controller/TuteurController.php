<?php

namespace App\Controller;

use App\Entity\Note;
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
    //ACCUEIL TUTEUR (liste les apprenants)
    #[IsGranted("ROLE_TUTEUR")]
    #[Route('/Tuteur/tuteurHome', name: 'tuteurHome')]
    public function TuteurHome(): Response
    {
        //Recupérer les apprenants du tuteur
        $user = $this->getUser();
        $apprenants = $user->getApprenants();

        return $this->render('main/tuteur/tuteurHome.html.twig', [
            'apprenants' => $apprenants,
            'user' => $user
        ]);
    }

    //PROFIL APPRENANT (liste les matieres)
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

    return $this->render('main/tuteur/tuteurApprenant.html.twig', [
            'apprenant' => $apprenant,
            'matieres' => $matieres
        ]);
    }

    //FICHE MATIERE (liste le programme)
    #[IsGranted("ROLE_TUTEUR")]
    #[Route('/Tuteur/{apprenantId}/Matiere/{matiereId}', name: 'tuteurMatiere')]
    public function TuteurMatiere($apprenantId, $matiereId, EntityManagerInterface $entityManager): Response
    {
        //Recupérer le repo de l'apprenant {id}
        $apprenantRepo = $entityManager->getRepository(Utilisateur::class);
        $apprenant = $apprenantRepo->find($apprenantId);
        //Recupérer le repo de la matière selectionnée {id}
        $matiereRepo = $entityManager->getRepository(Matiere::class);
        $matiere = $matiereRepo->find($matiereId);

        return $this->render('main/tuteur/tuteurMatiere.html.twig', [
            'matiere' => $matiere,
            'apprenant' => $apprenant
        ]);
    }

    //FICHE NOTES (liste les notes)
    #[IsGranted("ROLE_TUTEUR")]
    #[Route('/Tuteur/{apprenantId}/Notes', name: 'tuteurNotes')]
    public function TuteurNotes($apprenantId, EntityManagerInterface $entityManager): Response
    {
        //Recupérer les infos de l'apprenant
        $apprenantRepo = $entityManager->getRepository(Utilisateur::class);
        $apprenant = $apprenantRepo->find($apprenantId);
        //Recupérer les notes de l'apprenant
        $notesRepo = $entityManager->getRepository(Note::class);
        $notes = $notesRepo->findBy(['apprenant' => $apprenant]);

        // Do something with the notes...

        return $this->render('main/tuteur/tuteurNotes.html.twig', [
            'apprenant' => $apprenant,
            'notes' => $notes,
            'apprenant' => $apprenant
        ]);
    }
}
