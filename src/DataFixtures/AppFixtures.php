<?php

namespace App\DataFixtures;

use App\Entity\Note;
use App\Entity\Matiere;
use App\Entity\Formation;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $admin = new Utilisateur();
        $admin->setNom('admin');
        $admin->setPrenom('admin');
        $admin->setEmail('admin@admin.com');
        $adminHash = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($adminHash);
        $admin->setRoles(['ROLE_ADMIN']);




        //FORMATEUR
        $utilisateurThiery = new Utilisateur();
        $utilisateurThiery->setNom('Thiery');
        $utilisateurThiery->setPrenom('Guillaume');
        $utilisateurThiery->setEmail('guillaume.thiery@example.com');
        $utilisateurThieryHash = $this->passwordHasher->hashPassword($utilisateurThiery, 'guillaumeThiery');
        $utilisateurThiery->setPassword($utilisateurThieryHash);
        $utilisateurThiery->setRoles(['ROLE_FORMATEUR']);


        

        $utilisateurChereault = new Utilisateur();
        $utilisateurChereault->setNom('Chereault');
        $utilisateurChereault->setPrenom('Damien');
        $utilisateurChereault->setEmail( 'damien.chereault@example.com');
        $utilisateurChereaultHash = $this->passwordHasher->hashPassword($utilisateurChereault, 'damienChereault');
        $utilisateurChereault->setPassword($utilisateurChereaultHash);
        $utilisateurChereault->setRoles(['ROLE_FORMATEUR']);
        
        $utilisateurDelaune = new Utilisateur();
        $utilisateurDelaune->setNom('Delaune');
        $utilisateurDelaune->setPrenom('Oceane');
        $utilisateurDelaune->setEmail('oceane.delaune@example.com');
        $utilisateurDelauneHash = $this->passwordHasher->hashPassword($utilisateurDelaune, 'oceaneDelaune');
        $utilisateurDelaune->setPassword($utilisateurDelauneHash);
        $utilisateurDelaune->setRoles(['ROLE_FORMATEUR']);


        //APPRENANT
        $utilisateurGrancher = new Utilisateur();
        $utilisateurGrancher->setNom('Grancher');
        $utilisateurGrancher->setPrenom('Loic');
        $utilisateurGrancher->setEmail('loic.grancher@example.com');
        $utilisateurGrancherHash = $this->passwordHasher->hashPassword($utilisateurGrancher, 'loicGrancher');
        $utilisateurGrancher->setPassword($utilisateurGrancherHash);
        $utilisateurGrancher->setRoles(['ROLE_APPRENANT']);
      
        $utilisateurDelafenestre = new Utilisateur();
        $utilisateurDelafenestre->setNom("Delafenestre");
        $utilisateurDelafenestre->setPrenom('Alexis');
        $utilisateurDelafenestre->setEmail('alexis.delafenestre@example.com');
        $utilisateurDelafenestreHash = $this->passwordHasher->hashPassword($utilisateurDelafenestre, 'alexisDelafenestre');
        $utilisateurDelafenestre->setPassword($utilisateurDelafenestreHash);
        $utilisateurDelafenestre->setRoles(['ROLE_APPRENANT']);
      
        $utilisateurBordin = new Utilisateur();
        $utilisateurBordin->setNom("Bordin");
        $utilisateurBordin->setPrenom('Yohann');
        $utilisateurBordin->setEmail('yohann.bordin@example.com');
        $utilisateurBordinHash = $this->passwordHasher->hashPassword($utilisateurBordin, 'yohannBordin');
        $utilisateurBordin->setPassword($utilisateurBordinHash);
        $utilisateurBordin->setRoles(['ROLE_APPRENANT']);
      

        //Tuteurs
        $utilisateurBetty= new Utilisateur();
        $utilisateurBetty->setNom('Buhot');
        $utilisateurBetty->setPrenom('Betty');
        $utilisateurBetty->setEmail('betty.buhot@example.com');
        $utilisateurBettyHash = $this->passwordHasher->hashPassword($utilisateurBetty, 'bettyBuhot');
        $utilisateurBetty->setPassword($utilisateurBettyHash);
        $utilisateurBetty->setRoles(['ROLE_TUTEUR']);
        

        $utilisateurSandrine= new Utilisateur();
        $utilisateurSandrine->setNom('Lebaron');
        $utilisateurSandrine->setPrenom('Sandrine');
        $utilisateurSandrine->setEmail('sandrine.lebaron@example.com');
        $utilisateurSandrineHash = $this->passwordHasher->hashPassword($utilisateurSandrine, 'sandrineLebaron');
        $utilisateurSandrine->setPassword($utilisateurSandrineHash);
        $utilisateurSandrine->setRoles(['ROLE_TUTEUR']);
        

        //Matieres
        $matiereSymfony = new Matiere();
        $matiereSymfony->setNom('Symfony');
        $matiereSymfony->setProgramme("Symfony est un framework open-source créé par la communauté PHP");
        
        

        $matierePhp= new Matiere();
        $matierePhp->setNom('PHP');
        $matierePhp->setProgramme("PHP est un langage de programmation de scripts open-source");
        $matierePhp->setFormateur($utilisateurChereault);
       
        $matiereWordpress= new Matiere();
        $matiereWordpress->setNom('Wordpress');
        $matiereWordpress->setProgramme("Wordpress est un CMS open-source");
        $matiereWordpress->setFormateur($utilisateurDelaune);
       

        //Formations
        $formationDisii= new Formation();
        $formationDisii->setNom('Disii');
      

        $formationTssr= new Formation();
        $formationTssr->setNom('Tssr');
    
        $noteGrancher1 = new Note();
        $noteGrancher1->setApprenant($utilisateurGrancher);
        $noteGrancher1->setMatiere($matiereSymfony);
        $noteGrancher1->setNote('12.50');
        $noteGrancher1->setEvaluation('Examen 1');

        $noteGrancher2 = new Note();
        $noteGrancher2->setApprenant($utilisateurGrancher);
        $noteGrancher2->setMatiere($matierePhp);
        $noteGrancher2->setNote('15.00');
        $noteGrancher2->setEvaluation('Examen 1');

        $noteBordin1 = new Note();
        $noteBordin1->setApprenant($utilisateurBordin);
        $noteBordin1->setMatiere($matiereSymfony);
        $noteBordin1->setNote('10.00');
        $noteBordin1->setEvaluation('Examen A');


        $noteBordin2 = new Note();
        $noteBordin2->setApprenant($utilisateurBordin);
        $noteBordin2->setMatiere($matierePhp);
        $noteBordin2->setNote('12.00');
        $noteBordin2->setEvaluation('Examen A');

        
        //ASSOCIATIONS ---------------------------------

        //Donner les formations aux apprenants
        $utilisateurGrancher->setFormationSuivie($formationDisii);
        $utilisateurDelafenestre->setFormationSuivie($formationDisii);
        $utilisateurBordin->setFormationSuivie($formationTssr);

        //Donner les tuteurs aux apprenants
        $utilisateurGrancher->setTuteurAssigne($utilisateurBetty);
        $utilisateurDelafenestre->setTuteurAssigne($utilisateurBetty);
        $utilisateurBordin->setTuteurAssigne($utilisateurSandrine);

        //Donner des formateurs aux matieres
        $matiereSymfony->setFormateur($utilisateurThiery);
        $matierePhp->setFormateur($utilisateurChereault);
        $matiereWordpress->setFormateur($utilisateurDelaune);

        //associer formation et matieres
        $formationDisii->addMatiere($matiereSymfony);
        $formationDisii->addMatiere($matierePhp);
        $formationTssr->addMatiere($matierePhp);
        $formationTssr->addMatiere($matiereWordpress);

        $manager->persist($utilisateurThiery);
        $manager->persist($utilisateurChereault);
        $manager->persist($utilisateurDelaune);
        $manager->persist($utilisateurGrancher);
        $manager->persist($utilisateurDelafenestre);
        $manager->persist($utilisateurBordin);
        $manager->persist($utilisateurBetty);
        $manager->persist($utilisateurSandrine);
        $manager->persist($matiereSymfony);
        $manager->persist($matierePhp);
        $manager->persist($matiereWordpress);
        $manager->persist($formationDisii);
        $manager->persist($formationTssr);
        $manager->persist($noteGrancher1);
        $manager->persist($noteGrancher2);
        $manager->persist($noteBordin1);
        $manager->persist($noteBordin2);
        $manager->persist($admin);




        $manager->flush();
    }
}
