<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Formation;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatiereAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('programme')
            ->add('formateur', EntityType::class, [
                'class' => Utilisateur::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.roles LIKE :role')
                        ->setParameter('role', '%"ROLE_FORMATEUR"%');
                },
                'choice_label' => 'nom',
'choice_label' => 'nom',
            ])
            ->add('formation', EntityType::class, [
                'class' => Formation::class,
'choice_label' => 'nom',
'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matiere::class,
        ]);
    }
}
