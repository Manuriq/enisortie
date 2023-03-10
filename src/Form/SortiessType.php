<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut',DateTimeType::class,[
                'widget'=> 'single_text',
                'attr'=> ['class' => 'datePickerDebut'],
                'html5'=>false
            ])
            ->add('dateLimiteInscription',DateType::class,[
                'widget'=> 'single_text',
                'attr'=> ['class' => 'datePickerLimite'],
                'html5'=>false
            ])
            ->add('nbInscriptionsMax')
            ->add('duree')
            ->add('infosSortie')
            ->add('campus',TextType::class,[
                'attr'=> ['disabled' => true]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
