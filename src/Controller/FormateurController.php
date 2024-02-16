<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Entity\Matiere;
use App\Entity\Formation;
use App\Form\MatiereType;
use App\Entity\Utilisateur;
use App\Form\DeleteNoteType;
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
    public function FormateurFormation($formationId, EntityManagerInterface $entityManager): Response
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

    //APPRENANT
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

    //MATIERE
    #[IsGranted("ROLE_FORMATEUR")]
    #[Route('/Formateur/{formationId}/matiere/{matiereId}', name: 'formateurMatiere')]
    public function FormateurMatiere($formationId, $matiereId, EntityManagerInterface $entityManager): Response
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

    //CREER NOTE
    #[IsGranted("ROLE_FORMATEUR")]
    #[Route('/Formateur/{formationId}/apprenant/{apprenantId}/creerNote', name: 'formateurCreerNote')]
    public function FormateurCreerNote(EntityManagerInterface $entityManager, Request $request, $formationId, $apprenantId): Response
    {
        //Recupérer 'apprenant' et le formateur
        $apprenantRepo = $entityManager->getRepository(Utilisateur::class);
        $apprenant = $apprenantRepo->find($apprenantId);

        //Générer le formulaire
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        //envoyer le formulaire et traiter l'ajout
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $note = $form->getData();
            $entityManager->persist($note);
            $entityManager->flush();
            return $this->redirectToRoute('formateurApprenant', ['apprenantId' => $apprenantId, 'formationId' => $formationId]);
        }

        return $this->render('main/formateur/formateurCreerNote.html.twig', [
            'form' => $form->createView(),
            'apprenant' => $apprenant
        ]);
    }

    //SUPPRIMER NOTE
    #[IsGranted("ROLE_FORMATEUR")]
    #[Route('/Formateur/SupprimerNote/{noteId}', name: 'formateurSupprimerNote')]
    public function FormateurSupprimerNote(EntityManagerInterface $entityManager, $noteId): Response
    {

        //Recupérer noteID, 
        $noteRepo = $entityManager->getRepository(Note::class);
        $note = $noteRepo->find($noteId);
        //Vérifier si la note existe
        if (!$note) {
            throw $this->createNotFoundException('Grade not found');
        }
        //supprimer la note
        $entityManager->remove($note);
        $entityManager->flush();
        $this->addFlash('success', 'Grade deleted successfully.');

        //rediriger vers la formation
        return $this->redirectToRoute('formateurHome');
    }

    //MODIFIER NOTE PAGE
    #[IsGranted("ROLE_FORMATEUR")]
    #[Route('/Formateur/ModifierNote/{noteId}', name: 'formateurModifierNote')]
    public function FormateurModifierNote(EntityManagerInterface $entityManager, $noteId, Request $request): Response
    {

        //Recupérer noteID, 
        $noteRepo = $entityManager->getRepository(Note::class);
        $note = $noteRepo->find($noteId);
        //Vérifier si la note existe
        if (!$note) {
            throw $this->createNotFoundException('Grade not found');
        }
        $this->addFlash('success', 'Grade deleted successfully.');

        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newNote = $form->getData();
            $entityManager->persist($newNote);
            $entityManager->flush();
            return $this->redirectToRoute('formateurHome');
        }

        //Afficher le formulaire de modification
        return $this->render('main/formateur/formateurModifierNote.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
    }

    //MODIFIER PROGRAMME
    #[IsGranted("ROLE_FORMATEUR")]
    #[Route('/Formateur/{matiereId}/modifierProgramme', name: 'formateurModifierProgramme')]
    public function FormateurModifierProgramme(EntityManagerInterface $entityManager, $matiereId, Request $request ): Response
    {

        //Recupérer matiereID, 
        $matiereRepo = $entityManager->getRepository(Matiere::class);
        $matiere = $matiereRepo->find($matiereId);
        //Vérifier si la matiere existe
        if (!$matiere) {
            throw $this->createNotFoundException('Matiere not found');
        }

        //Générer le formulaire pour la matiere
        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newMatiere = $form->getData();
            $entityManager->persist($newMatiere);
            $entityManager->flush();
            return $this->redirectToRoute('formateurHome');
        }

        //Afficher le formulaire de modification
        return $this->render('main/formateur/formateurModifierProgramme.html.twig', [
            'matiere' => $matiere,
            'form' => $form->createView(),

        ]);
    }
} 