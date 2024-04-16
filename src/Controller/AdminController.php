<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Matiere;
use App\Entity\Formation;
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
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin', name: 'adminHome')]
    public function AdminHome(EntityManagerInterface $entityManager, Request $request): Response
    {
        return $this->render('admin/adminHome.html.twig');
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/user', name: 'adminNewUser')]
    public function AdminNewUser(EntityManagerInterface $entityManager, Request $request, LoggerInterface $logger, UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurAdminType::class, $utilisateur);
        //envoyer le formulaire et traiter l'ajout
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //Get the data from the form
                $utilisateur = $form->getData();
                
                // Get and hash the password
                $hashedPassword = $passwordHasher->hashPassword($utilisateur, $utilisateur->getPassword());
                // Set the hashed password
                $utilisateur->setPassword($hashedPassword);

                // Persist the user to the database
                $entityManager->persist($utilisateur);
                $entityManager->flush();
                return $this->redirectToRoute('adminHome');
            } catch (\Exception $e) {
                // Log any exceptions that occur during entity persistence
                $logger->error('Error occurred while persisting utilisateur: ' . $e->getMessage());
            }
        }

        return $this->render('admin/adminNewUser.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/formation', name: 'adminNewFormation')]
    public function AdminNewFormation(EntityManagerInterface $entityManager, Request $request): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationAdminType::class, $formation);
        //envoyer le formulaire et traiter l'ajout
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

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/matiere', name: 'adminNewMatiere')]
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

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/note', name: 'adminNewNote')]
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

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/adminSuccess', name: 'adminSuccess')]
    public function AdminSuccess(): Response
    {
        return $this->render('admin/adminSuccess.html.twig', []);
    }
}
