<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Matiere;
use App\Entity\Formation;
use App\Form\MatiereType;
use App\Entity\Utilisateur;
use App\Form\NoteAdminType;
use Psr\Log\LoggerInterface;
use App\Form\MatiereAdminType;
use App\Form\FormationAdminType;
use App\Form\UtilisateurAdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{
    //PAGE_ACCUEIL_ADMIN
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin', name: 'adminHome')]
    public function AdminHome(): Response
    {
        return $this->render('admin/adminHome.html.twig');
    }





    //USER_CRUD ------------------------------------------------
    //USER_ADD
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/new/Utilisateur', name: 'adminNewUtilisateur')]
    public function AdminNewUtilisateur(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        //Créer un nouvel utilisateur
        $utilisateur = new Utilisateur();
        //Créer un formulaire de type utilisateur
        $form = $this->createForm(UtilisateurAdminType::class, $utilisateur);
        //Récuperer le formulaire rempli
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //On recupere les donnée du formulaire
            $utilisateur = $form->getData();
            // On hash le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($utilisateur, $utilisateur->getPassword());
            // On change le mot de passe de l'utilisateur
            $utilisateur->setPassword($hashedPassword);
            // On enregistre l'utilisateur
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->redirectToRoute('adminHome');
        }

        return $this->render('admin/adminNewUtilisateur.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //USER_LIST
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/utilisateurs', name: 'adminUtilisateurs')]
    public function AdminUtilisateurs(EntityManagerInterface $entityManager, Request $request): Response
    {
        $utilisateurs = $entityManager->getRepository(Utilisateur::class)->findBy([], ['nom' => 'ASC']);
        return $this->render('admin/adminUtilisateurs.html.twig', [
            'utilisateurs' => $utilisateurs
        ]);
    }

    //USER_MODIFIER TODO
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/utilisateurs/{utilisateurId}', name: 'adminModifierUtilisateur')]
    public function AdminModifierUtilisateur(EntityManagerInterface $entityManager, $utilisateurId, Request $request): Response
    {

        //Recupérer utilisateur , 
        $utilisateurRepo = $entityManager->getRepository(Utilisateur::class);
        $utilisateur = $utilisateurRepo->find($utilisateurId);
        //Vérifier si la matiere existe
        if (!$utilisateur) {
            throw $this->createNotFoundException('Matiere not found');
        }

        //Générer le formulaire 
        $form = $this->createForm(UtilisateurAdminType::class, $utilisateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // L'entité utilisateur est automatiquement mise à jour avec les données soumises
            $entityManager->flush();

            return $this->redirectToRoute('adminUtilisateurs');
        }

        //Afficher le formulaire de modification
        return $this->render('admin/adminModifierUtilisateur.html.twig', [

            'form' => $form->createView(),

        ]);
    }
    
    //USER_SUPPRIMER (TODO)
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/utilisateurs/supprimer/{utilisateurId}', name: 'adminSupprimerUtilisateur')]
    public function AdminSupprimerUtilisateur(EntityManagerInterface $entityManager, $utilisateurId, Request $request): Response
    {
        //Recupérer utilisateur , 
        $utilisateurRepo = $entityManager->getRepository(Utilisateur::class);
        $utilisateur = $utilisateurRepo->find($utilisateurId);
        //Vérifier si la matiere existe
        if (!$utilisateur) {
            throw $this->createNotFoundException('Matiere not found');
        }
        //Supprimer l'utilisateur
        $entityManager->remove($utilisateur);
        $entityManager->flush();
        $this->addFlash('success', 'Grade deleted successfully.');

        //Afficher le formulaire de modification
        return $this->redirectToRoute('adminUtilisateurs');
    }





    //FORMATION_CRUD ------------------------------------------------
    //FORMATION_ADD
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/new/Formation', name: 'adminNewFormation')]
    public function AdminNewFormation(EntityManagerInterface $entityManager, Request $request): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationAdminType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formation = $form->getData();
            $entityManager->persist($formation);
            $entityManager->flush();
            return $this->redirectToRoute('adminHome');
        }

        return $this->render('admin/adminNewFormation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //FORMATION_LIST
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/formations', name: 'adminFormations')]
    public function AdminFormations(EntityManagerInterface $entityManager): Response
    {
        $formations = $entityManager->getRepository(Formation::class)->findBy([], ['nom' => 'ASC']);;
        return $this->render('admin/adminFormations.html.twig', [
            'formations' => $formations
        ]);
    }

    //FORMATION_MODIFIER
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/formations/{formationId}', name: 'adminModifierFormation')]
    public function AdminModifierFormation(EntityManagerInterface $entityManager, $formationId, Request $request): Response
    {
        //Recupérer formation , 
        $formation = $entityManager
            ->getRepository(Formation::class)
            ->find($formationId);
        //Vérifier si la matiere existe
        if (!$formation) {
            throw $this->createNotFoundException('Formation not found');
        }

        //Générer le formulaire 
        $form = $this->createForm(FormationAdminType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // L'entité utilisateur est automatiquement mise à jour avec les données soumises
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('adminFormations');
        }

        //Afficher le formulaire de modification
        return $this->render('admin/adminModifierFormation.html.twig', [

            'form' => $form->createView(),
            'formation' => $formation

        ]);
    }

    //FORMATION_SUPPRIMER
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/formations/supprimer/{formationId}', name: 'adminSupprimerFormation')]
    public function AdminSupprimerFormation(EntityManagerInterface $entityManager, $formationId): Response
    {
        //Recupérer formation , 
        $formation = $entityManager
            ->getRepository(Formation::class)
            ->find($formationId);
        //Vérifier si la matiere existe
        if (!$formation) {
            throw $this->createNotFoundException('Formation not found');
        }
        //Supprimer la formation
        $entityManager->remove($formation);
        $entityManager->flush();
        $this->addFlash('success', 'Formation deleted successfully.');

        return $this->redirectToRoute('adminFormations');
    }










    //MATIERE_CRUD -------------------------------------------------
    //MATIERE_ADD
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/new/Matiere', name: 'adminNewMatiere')]
    public function AdminNewMatiere(EntityManagerInterface $entityManager, Request $request): Response
    {
        $matiere = new Matiere();
        $form = $this->createForm(MatiereAdminType::class, $matiere);
        //envoyer le formulaire et traiter l'ajout
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $matiere = $form->getData();
            $entityManager->persist($matiere);
            $entityManager->flush();
            return $this->redirectToRoute('adminHome');
        }

        return $this->render('admin/adminNewMatiere.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //MATIERE_LIST
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/matieres', name: 'adminMatieres')]
    public function AdminMatiereList(EntityManagerInterface $entityManager): Response
    {
        $matieres = $entityManager->getRepository(Matiere::class)->findBy([], ['nom' => 'ASC']);
        return $this->render('admin/adminMatieres.html.twig', [
            'matieres' => $matieres
        ]);
    }

    //MATIERE_MODIFIER
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/matieres/{matiereId}', name: 'adminModifierMatiere')]
    public function AdminModifierMatiere(EntityManagerInterface $entityManager, $matiereId, Request $request): Response
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
            return $this->redirectToRoute('adminMatieres');
        }

        //Afficher le formulaire de modification
        return $this->render('admin/adminModifierMatiere.html.twig', [
            'matiere' => $matiere,
            'form' => $form->createView(),

        ]);
    }
    
    //MATIERE_SUPPRIMER
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/formations/supprimer/{matiereId}', name: 'adminSupprimerMatiere')]
    public function AdminSupprimerMatiere(EntityManagerInterface $entityManager, $matiereId): Response
    {
        //Recupérer formation , 
        $matiere = $entityManager
            ->getRepository(Matiere::class)
            ->find($matiereId);
        //Vérifier si la matiere existe
        if (!$matiere) {
            throw $this->createNotFoundException('Matiere not found');
        }
        //Supprimer la formation
        $entityManager->remove($matiere);
        $entityManager->flush();
        $this->addFlash('success', 'Matiere deleted successfully.');

        return $this->redirectToRoute('adminMatieres');
    }








    //NOTE_CRUD ------------------------------------------------
    //NOTE_ADD
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/new/Note', name: 'adminNewNote')]
    public function AdminNewNote(EntityManagerInterface $entityManager, Request $request): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteAdminType::class, $note);
        //envoyer le formulaire et traiter l'ajout
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $note = $form->getData();
            $entityManager->persist($note);
            $entityManager->flush();
            return $this->redirectToRoute('adminHome');
        }

        return $this->render('admin/adminNewNote.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //NOTE_LIST
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/notes', name: 'adminNotes')]
    public function AdminNoteList(EntityManagerInterface $entityManager): Response
    {
        $notes = $entityManager->getRepository(Note::class)->findBy([], ['evaluation' => 'ASC']);
        return $this->render('admin/adminNotes.html.twig', [
            'notes' => $notes
        ]);
    }

    //NOTE_MODIFIER
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/notes/{noteId}', name: 'adminModifierNote')]
    public function AdminModifierNote(EntityManagerInterface $entityManager, $noteId, Request $request): Response
    {
        //Recupérer formation , 
        $note = $entityManager
            ->getRepository(Note::class)
            ->find($noteId);
        //Vérifier si la matiere existe
        if (!$note) {
            throw $this->createNotFoundException('Note not found');
        }

        //Générer le formulaire 
        $form = $this->createForm(NoteAdminType::class, $note);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // L'entité utilisateur est automatiquement mise à jour avec les données soumises
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('adminNotes');
        }

        //Afficher le formulaire de modification
        return $this->render('admin/adminModifierNote.html.twig', [

            'form' => $form->createView(),
            'note' => $note

        ]);
    }

    //NOTE_SUPPRIMER
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/notes/supprimer/{noteId}', name: 'adminSupprimerNote')]
    public function AdminSupprimerNote(EntityManagerInterface $entityManager, $noteId): Response
    {
        //Recupérer formation , 
        $note = $entityManager
            ->getRepository(Note::class)
            ->find($noteId);
        //Vérifier si la matiere existe
        if (!$note) {
            throw $this->createNotFoundException('Formation not found');
        }
        //Supprimer la formation
        $entityManager->remove($note);
        $entityManager->flush();
        $this->addFlash('success', 'Note deleted successfully.');

        return $this->redirectToRoute('adminNotes');
    }
}
