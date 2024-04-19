<?php

namespace App\Form;

use App\Entity\Note;
use App\Entity\Matiere;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note')
            ->add('evaluation')
            ->add('matiere', EntityType::class, [
                'class' => Matiere::class,
'choice_label' => 'nom',
            ])
            ->add('apprenant', EntityType::class, [
                'class' => Utilisateur::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.roles LIKE :role')
                        ->setParameter('role', '%"ROLE_APPRENANT"%');
                },
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
