<?php

namespace App\DataFixtures;

use App\Entity\Matiere;
use App\Entity\Formation;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //FORMATEUR
        $utilisateurThiery = new Utilisateur();
        $utilisateurThiery->setNom('Thiery');
        $utilisateurThiery->setPrenom('Guillaume');
        $utilisateurThiery->setEmail('guillaume.thiery@example.com');
        $utilisateurThiery->setPassword('guillaumeThiery');
        $utilisateurThiery->setRoles(['ROLE_FORMATEUR']);


        

        $utilisateurChereault = new Utilisateur();
        $utilisateurChereault->setNom('Chereault');
        $utilisateurChereault->setPrenom('Damien');
        $utilisateurChereault->setEmail( 'damien.chereault@example.com');
        $utilisateurChereault->setPassword('damienChereault');
        $utilisateurChereault->setRoles(['ROLE_FORMATEUR']);
        
        $utilisateurDelaune = new Utilisateur();
        $utilisateurDelaune->setNom('Delaune');
        $utilisateurDelaune->setPrenom('Oceane');
        $utilisateurDelaune->setEmail('oceane.delaune@example.com');
        $utilisateurDelaune->setPassword('oceaneDelaune');
        $utilisateurDelaune->setRoles(['ROLE_FORMATEUR']);


        //APPRENANT
        $utilisateurGrancher = new Utilisateur();
        $utilisateurGrancher->setNom('Grancher');
        $utilisateurGrancher->setPrenom('Loic');
        $utilisateurGrancher->setEmail('loic.grancher@example.com');
        $utilisateurGrancher->setPassword('loicGrancher');
        $utilisateurGrancher->setRoles(['ROLE_APPRENANT']);
      
        $utilisateurDelafenestre = new Utilisateur();
        $utilisateurDelafenestre->setNom("Delafenestre");
        $utilisateurDelafenestre->setPrenom('Alexis');
        $utilisateurDelafenestre->setEmail('alexis.delafenestre@example.com');
        $utilisateurDelafenestre->setPassword('alexisDelafenestre');
        $utilisateurDelafenestre->setRoles(['ROLE_APPRENANT']);
      
        $utilisateurBordin = new Utilisateur();
        $utilisateurBordin->setNom("Bordin");
        $utilisateurBordin->setPrenom('Yohann');
        $utilisateurBordin->setEmail('yohann.bordin@example.com');
        $utilisateurBordin->setPassword('yohannBordin');
        $utilisateurBordin->setRoles(['ROLE_APPRENANT']);
      

        //Tuteurs
        $utilisateurBetty= new Utilisateur();
        $utilisateurBetty->setNom('Buhot');
        $utilisateurBetty->setPrenom('Betty');
        $utilisateurBetty->setEmail('betty.buhot@example.com');
        $utilisateurBetty->setPassword('bettyBuhot');
        $utilisateurBetty->setRoles(['ROLE_TUTEUR']);
        

        $utilisateurSandrine= new Utilisateur();
        $utilisateurSandrine->setNom('Lebaron');
        $utilisateurSandrine->setPrenom('Sandrine');
        $utilisateurSandrine->setEmail('sandrine.lebaron@example.com');
        $utilisateurSandrine->setPassword('sandrineLebaron');
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




        $manager->flush();
    }
}
