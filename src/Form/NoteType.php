<?php

namespace App\Form;

use App\Entity\Note;
use App\Entity\Matiere;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NoteType extends AbstractType
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->token->getToken()->getUser();

        $builder
        ->add('note', NumberType::class, [
            'constraints' => [
                new Range([
                    'min' => 1,
                    'max' => 20,
                    'notInRangeMessage' => 'Please enter a number between {{ min }} and {{ max }}.',
                ]),
            ],
        ])
            ->add('evaluation')
            ->add('matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('m')
                        ->join('m.formateur', 'f')
                        ->where('f.id = :userId')
                        ->setParameter('userId', $user->getId());
                },
            ])
            ->add('apprenant', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => function (Utilisateur $utilisateur) {
                    return $utilisateur->getNom() . ' ' . $utilisateur->getPrenom();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :roles')
                        ->setParameter('roles', '%"ROLE_APPRENANT"%');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
