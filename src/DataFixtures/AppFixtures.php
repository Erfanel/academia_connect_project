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

        $manager->persist($utilisateurThiery);

        $utilisateurChereault = new Utilisateur();
        $utilisateurChereault->setNom('Chereault');
        $utilisateurChereault->setPrenom('Damien');
        $utilisateurChereault->setEmail( 'damien.chereault@example.com');
        $utilisateurChereault->setPassword('damienChereault');
        $manager->persist($utilisateurChereault);

        $utilisateurDelaune = new Utilisateur();
        $utilisateurDelaune->setNom('Delaune');
        $utilisateurDelaune->setPrenom('Oceane');
        $utilisateurDelaune->setEmail('oceane.delaune@example.com');
        $utilisateurDelaune->setPassword('oceaneDelaune');
        $manager->persist($utilisateurDelaune);

        //APPRENANT
        $utilisateurGrancher = new Utilisateur();
        $utilisateurGrancher->setNom('Grancher');
        $utilisateurGrancher->setPrenom('Loic');
        $utilisateurGrancher->setEmail('loic.grancher@example.com');
        $utilisateurGrancher->setPassword('loicGrancher');
        $manager->persist($utilisateurGrancher);

        $utilisateurDelafenestre = new Utilisateur();
        $utilisateurDelafenestre->setNom("Delafenestre");
        $utilisateurDelafenestre->setPrenom('Alexis');
        $utilisateurDelafenestre->setEmail('alexis.delafenestre@example.com');
        $utilisateurDelafenestre->setPassword('alexisDelafenestre');
        $manager->persist($utilisateurDelafenestre);

        $utilisateurBordin = new Utilisateur();
        $utilisateurBordin->setNom("Bordin");
        $utilisateurBordin->setPrenom('Yohann');
        $utilisateurBordin->setEmail('yohann.bordin@example.com');
        $utilisateurBordin->setPassword('yohannBordin');
        $manager->persist($utilisateurBordin);

        //Tuteurs
        $utilisateurBetty= new Utilisateur();
        $utilisateurBetty->setNom('Buhot');
        $utilisateurBetty->setPrenom('Betty');
        $utilisateurBetty->setEmail('betty.buhot@example.com');
        $utilisateurBetty->setPassword('bettyBuhot');
        $manager->persist($utilisateurBetty);

        $utilisateurSandrine= new Utilisateur();
        $utilisateurSandrine->setNom('Lebaron');
        $utilisateurSandrine->setPrenom('Sandrine');
        $utilisateurSandrine->setEmail('sandrine.lebaron@example.com');
        $utilisateurSandrine->setPassword('sandrineLebaron');
        $manager->persist($utilisateurSandrine);

        //Matieres
        $matiereSymfony = new Matiere();
        $matiereSymfony->setNom('Symfony');
        $matiereSymfony->setProgramme("Symfony est un framework open-source créé par la communauté PHP");
        $matiereSymfony->setFormateur($utilisateurThiery);
        $manager->persist($matiereSymfony);

        $matierePhp= new Matiere();
        $matierePhp->setNom('PHP');
        $matierePhp->setProgramme("PHP est un langage de programmation de scripts open-source");
        $matierePhp->setFormateur($utilisateurChereault);
        $manager->persist($matierePhp);

        $matiereWordpress= new Matiere();
        $matiereWordpress->setNom('Wordpress');
        $matiereWordpress->setProgramme("Wordpress est un CMS open-source");
        $matiereWordpress->setFormateur($utilisateurDelaune);
        $manager->persist($matiereWordpress);

        //Formations
        $formationDisii= new Formation();
        $formationDisii->setNom('Disii');
        $manager->persist($formationDisii);

        $formationTssr= new Formation();
        $formationTssr->setNom('Tssr');
        $manager->persist($formationTssr);

        
        //ASSOCIATIONS ---------------------------------

        //Donner les formations aux apprenants
        $utilisateurGrancher->setFormationSuivie($formationDisii);
        $utilisateurDelafenestre->setFormationSuivie($formationDisii);
        $utilisateurDelafenestre->setFormationSuivie($formationTssr);

        //Donner les tuteurs aux apprenants
        $utilisateurGrancher->setTuteurAssigne($utilisateurBetty);
        $utilisateurDelafenestre->setTuteurAssigne($utilisateurBetty);
        $utilisateurDelafenestre->setTuteurAssigne($utilisateurSandrine);

        //Donner des formateurs aux matieres
        $matiereSymfony->setFormateur($utilisateurThiery);
        $matierePhp->setFormateur($utilisateurChereault);
        $matiereWordpress->setFormateur($utilisateurDelaune);

        //associer formation et matieres
        $formationDisii->addMatiere($matiereSymfony);
        $formationDisii->addMatiere($matierePhp);
        $formationTssr->addMatiere($matierePhp);
        $formationTssr->addMatiere($matiereWordpress);

        $manager->flush();
    }
}
