<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Aliment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\{ChoiceType,SubmitType,ResetType, CollectionType};

class AlimentsFavorisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        // $builder->add('aliments', CollectionType::class, [
        //     // each entry in the array will be an "email" field
        //     'entry_type' =>  AlimentType::class,
        //     // these options are passed to each "email" type
        //     'allow_add' => true,
        // ]);
        
    for ($i = 1; $i <= 10; $i++) {
      $builder->add('Aliment'.$i, EntityType::class, 
        [   'class' => Aliment::class,
            'choice_label' => 'alim_nom_fr',
            'choice_value' => 'alim_code']);
    }

    //    for ($i = 1; $i <= 9; $i++) {
    //   $builder->add('Aliment'.$i, AlimentType::class);
    // }
    
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
