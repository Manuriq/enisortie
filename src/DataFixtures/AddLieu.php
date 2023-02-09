<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AddLieu extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ville = new Ville();
        $ville->setNom("Nantes");
        $ville->setCodePostal("44000");
        $manager->persist($ville);

        $lieu = new Lieu();
        $lieu->setVille($ville);
        $lieu->setNom("Visite au musée");
        $lieu->setRue("17 rue docteur boileau");
        $lieu->setLatitude(100);
        $lieu->setLongitude(100);
        $manager->persist($lieu);
        $manager->flush();
    }
}
