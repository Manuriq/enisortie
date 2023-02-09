<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AddEtat extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $etat = new Etat();
        $etat->setLibelle("Créée");
        $manager->persist($etat);

        $etat2 = new Etat();
        $etat2->setLibelle("Ouverte");
        $manager->persist($etat2);
 
        $etat3 = new Etat();
        $etat3->setLibelle("Activité en cours");
        $manager->persist($etat3);

        $etat4 = new Etat();
        $etat4->setLibelle("Passée");
        $manager->persist($etat4);

        $etat5 = new Etat();
        $etat5->setLibelle("Annulée");
        $manager->flush();
    }
}
