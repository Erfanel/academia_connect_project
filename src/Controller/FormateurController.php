<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Entity\Matiere;
use App\Entity\Formation;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{

    #[IsGranted("ROLE_FORMATEUR")]
    #[Route('/Formateur', name: 'formateurHome')]
    public function FormateurHome(): Response
    {
        //Recupérer les matieres du formateur
        $user = $this->getUser();
        $matieres = $user->getMatiereEnseignee();
        // Récupérer les formations de chaque matiere
        foreach ($matieres as $matiere) {
            $formations = $matiere->getFormation();
        }

        return $this->render('main/formateur/formateurHome.html.twig', [
            'matieres' => $matieres,
            'formations' => $formations
        ]);
    }

    #[IsGranted("ROLE_FORMATEUR")]
    #[Route('/Formateur/{formationId}/', name: 'formateurFormation')]
    public function FormateurFormation($formationId,EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $matieres = $user->getMatiereEnseignee();
        //Recupérer le repo de la formation {id}
        $formationRepo = $entityManager->getRepository(Formation::class);
        //extraire l'ID et les apprenants de la formation
        $formation = $formationRepo->find($formationId);
        $apprenants = $formation->getApprenants();

        return $this->render('main/formateur/formateurFormation.html.twig', [
            'formation' => $formation,
            'matieres' => $matieres,
            'apprenants' => $apprenants
        ]);
    }

    #[IsGranted("ROLE_FORMATEUR")]
    #[Route('/Formateur/{formationId}/apprenant/{apprenantId}/', name: 'formateurApprenant')]
    public function FormateurApprenant($formationId, $apprenantId, EntityManagerInterface $entityManager): Response
    {
        //Recupérer le repo de la matiere {id}
        $apprenantRepo = $entityManager->getRepository(Utilisateur::class);
        //extraire l'ID et les apprenants de la matiere
        $apprenant = $apprenantRepo->find($apprenantId);

        return $this->render('main/formateur/formateurApprenant.html.twig', [
            'apprenant' => $apprenant,
            'formationId' => $formationId
        ]);
    }

    #[IsGranted("ROLE_FORMATEUR")]
    #[Route('/Formateur/{formationId}/matiere/{matiereId}', name: 'formateurMatiere')]
    public function FormateurMatiere($formationId, $matiereId,EntityManagerInterface $entityManager): Response
    {
        //Recupérer le repo de la matiere {id}
        $matiereRepo = $entityManager->getRepository(Matiere::class);
        //extraire l'ID et les apprenants de la matiere
        $matiere = $matiereRepo->find($matiereId);

        //Recupérer le repo de la formation {id}
        $formationRepo = $entityManager->getRepository(Formation::class);
        //extraire l'ID et les apprenants de la formation
        $formation = $formationRepo->find($formationId);

        return $this->render('main/formateur/formateurMatiere.html.twig', [
            'matiere' => $matiere,
            'formation' => $formation
        ]);
    }
    
    #[IsGranted("ROLE_FORMATEUR")]
    #[Route('/Formateur/{formationId}/apprenant/{apprenantId}/creerNote', name: 'formateurCreerNote')]
    public function FormateurCreerNote(EntityManagerInterface $entityManager, Request $request, $formationId, $apprenantId): Response
    {
        //Recupérer 'apprenant' et le formateur
        $apprenantRepo = $entityManager->getRepository(Utilisateur::class);
        $apprenant = $apprenantRepo->find($apprenantId);
        

        //générer le formulaire
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        //envoyer le formulaire et traiter l'ajout
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $note = $form->getData();
            $entityManager->persist($note);
            $entityManager->flush();
            return $this->redirectToRoute('formateurApprenant', [ 'apprenantId' => $apprenantId, 'formationId' => $formationId]);
        }

        return $this->render('main/formateur/formateurCreerNote.html.twig', [
            'form' => $form->createView(),
            'apprenant' => $apprenant
        ]);
    }

    



}
