<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut')
            ->add('duree')
            ->add('dateLimiteInscription')
            ->add('nbInscriptionsMax')
            ->add('infosSortie')
            ->add('etat')
            ->add('campus')
            ->add('organisateur')
            ->add('listeInscrits')
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
