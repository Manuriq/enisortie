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
        $etat->setLibelle("En création");
        $manager->persist($etat);

        $etat2 = new Etat();
        $etat2->setLibelle("Ouverte");
        $manager->persist($etat2);

        $etat3 = new Etat();
        $etat3->setLibelle("Clôturée");
        $manager->persist($etat3);
 
        $etat4 = new Etat();
        $etat4->setLibelle("Activité en cours");
        $manager->persist($etat4);

        $etat5 = new Etat();
        $etat5->setLibelle("Activité terminée");
        $manager->persist($etat5);

        $etat6 = new Etat();
        $etat6->setLibelle("Activité historisée");
        $manager->persist($etat6);

        $etat7 = new Etat();
        $etat7->setLibelle("Annulée");
        $manager->persist($etat7);

        $manager->flush();
    }
}
