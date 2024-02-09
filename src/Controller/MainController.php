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



class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('app_login');
    }


    #[Route('/homeAll', name: 'homeAll')]
    public function homeAll(): Response
    {
        switch ($this->getUser()->getRoles()[0]) {
            case 'ROLE_FORMATEUR':
                return $this->redirectToRoute('formateurHome');
            case 'ROLE_TUTEUR':
                return $this->redirectToRoute('tuteurHome');
            case 'ROLE_APPRENANT':
                return $this->redirectToRoute('apprenantHome');
        }
        return $this->redirectToRoute('error');
    }
}
