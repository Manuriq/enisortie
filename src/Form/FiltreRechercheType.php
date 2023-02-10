<?php

namespace App\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus',EntityType::class,[
                'class'=>'App\Entity\Campus',
                'placeholder'=>'Choix du campus',
                'mapped'=>false
            ])
            ->add('nom',TextType::class,[
                'label'=>'Le nom de la sortie contient',
                'required'=>false,
                'attr'=>['placeholder'=>'Search']
            ])
            ->add('dateDebut',DateType::class,[
                'data'=>new \DateTime(),
                'label'=>'Entre :',
                'required'=>false,
                'html5'=> true,
                'widget'=>'single_text'])
            ->add('dateFin',DateType::class,[
                'data'=>new \DateTime(),
                'label'=>' et le ',
                'required'=>false,
                'html5'=> true,
                'widget'=>'single_text'])
            ->add('checkOrganisateur',CheckboxType::class,[
                'label'=>'Sorties dont je suis l\'organisateur/trice',
                'required'=>false])
            ->add('checkSortiesInscrit',CheckboxType::class,[
                'label'=>'Sorties auxquelles je suis inscrit/e',
                'required'=>false])
            ->add('checkSortiesNonInscrit',CheckboxType::class,[
                'label'=>'Sorties auxquelles je ne suis pas inscrit/e',
                'required'=>false])
            ->add('checkSortiesPassees',CheckboxType::class,[
                'label'=>'Sorties passées',
                'required'=>false])
            ->add('submit',SubmitType::class,['label'=>'🔍',
                'attr'=>['class'=>'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

    }
}
