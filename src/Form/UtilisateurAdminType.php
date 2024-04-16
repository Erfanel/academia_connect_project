<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityRepository;
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
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('password')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Formateur' => 'ROLE_FORMATEUR',
                    'Tuteur' => 'ROLE_TUTEUR',
                    'Apprenant' => 'ROLE_APPRENANT',
                ],
                'multiple' => true, // If users can have multiple roles
                'expanded' => true, // If you want to render checkboxes or radio buttons
            ])
            ->add('formationSuivie', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'nom',
            ])
            ->add('tuteurAssigne', EntityType::class, [
                'class' => Utilisateur::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.roles LIKE :role')
                        ->setParameter('role', '%"ROLE_TUTEUR"%');
                },
                'choice_label' => 'nom',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
