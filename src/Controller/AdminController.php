<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Matiere;
use App\Entity\Note;
use App\Entity\Utilisateur;
use App\Form\FormationAdminType;
use App\Form\MatiereAdminType;
use App\Form\NoteAdminType;
use App\Form\UtilisateurAdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function AdminNewUser(EntityManagerInterface $entityManager, Request $request): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurAdminType::class, $utilisateur);
        //envoyer le formulaire et traiter l'ajout
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $form->getData();
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->redirectToRoute('adminHome');
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
