<?php

namespace App\Form;

use App\Entity\UtilisateurConnecte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{TextType,SubmitType, ResetType};


class UtilisateurConnectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            -> add('id')
            -> add('password')
            -> add('valider', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
            -> add('reinitialiser', ResetType::class, ['attr' => ['class' => 'btn btn-primary']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UtilisateurConnecte::class,
        ]);
    }
}
