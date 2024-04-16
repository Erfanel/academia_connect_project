<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UtilisateurAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Formateur' => 'ROLE_FORMATEUR',
                    'Tuteur' => 'ROLE_TUTEUR',
                    'Apprenant' => 'ROLE_APPRENANT',
                    // Add more roles as needed
                ],
                'multiple' => true, // If users can have multiple roles
                'expanded' => true, // If you want to render checkboxes or radio buttons
            ])
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('formationSuivie', EntityType::class, [
                'class' => Formation::class,
'choice_label' => 'nom',
            ])
            ->add('tuteurAssigne', EntityType::class, [
                'class' => Utilisateur::class,
'choice_label' => 'nom', 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);

    }
}
