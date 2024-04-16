<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Matiere;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
