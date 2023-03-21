<?php

namespace App\Form;

use App\Entity\Aliment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AlimentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('alim_code', EntityType::class, [
            'class' => Aliment::class,
            'choice_label' => 'alim_nom_fr',
            'choice_value' => 'alim_code',
            'label' => 'Votre aliment favoris: '
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aliment::class,
        ]);
    }
}
