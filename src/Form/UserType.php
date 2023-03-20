<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{TextType, IntegerType, NumberType, PasswordType, SubmitType, ResetType, TelType, BirthdayType};

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder -> add('id', IntegerType::class)
         //-> add('pseudo', TextType::class)
         -> add('password', PasswordType::class)
         -> add('nom', TextType::class)
         -> add('prenom', TextType::class)
         -> add('naissance', BirthdayType::class)
         -> add('c_postal', NumberType::class)
         -> add('num_tel', TelType::class)
         -> add('ville', TextType::class)
         -> add('adresse', TextType::class)
         
         -> add('valider', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
         -> add('reinitialiser', ResetType::class, ['attr' => ['class' => 'btn btn-primary']]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }

    
}
