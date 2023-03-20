<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Aliment;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType,SubmitType,ResetType};

class AlimentsFavorisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
    for ($i = 1; $i <= 9; $i++) {
      $builder->add('Aliment'.$i, EntityType::class, 
        [   'class' => Aliment::class,
            'choice_label' => 'alim_nom_fr',
            'choice_value' => 'alim_code']);
    }

    
    $builder
        -> add('valider', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
        -> add('reinitialiser', ResetType::class, ['attr' => ['class' => 'btn btn-primary']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
