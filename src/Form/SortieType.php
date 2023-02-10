<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut',DateTimeType::class,[
                'data'=> new \DateTime()])
            ->add('duree')
            ->add('dateLimiteInscription',DateType::class,[
                'data'=> new \DateTime()])
            ->add('nbInscriptionsMax')
            ->add('infosSortie')
            ->add('ville',EntityType::class,[
                'class'=>Ville::class,
                'query_builder'=>function (EntityRepository $er){
                return $er->createQueryBuilder('v')->orderBy('v.codePostal','ASC');
            },
                'placeholder'=>'Choisissez une ville',
            'mapped'=>false
            ])
            ->add('lieu',EntityType::class,[
                'class'=>Lieu::class
            ])
            ->add('save',SubmitType::class,['label'=>'Enregistrer'])
            ->add('publish',SubmitType::class,['label'=>'Publier'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
            'mapped' => false
        ]);
    }
}
