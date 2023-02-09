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
        for ($i = 0; $i < 5;$i++){

            $ville = new Ville();
            $ville->setNom("Ville $i");
            $ville->setCodePostal("CP :44.$i.00");
            $manager->persist($ville);

            for($j = 0; $j < 10; $j++) {

                $lieu = new Lieu();
                $lieu->setVille($ville);
                $lieu->setNom("Visite au musée $j de la ville $i");
                $lieu->setRue("17 rue docteur boileau");
                $lieu->setLatitude(100+$j);
                $lieu->setLongitude(100+$j);
                $manager->persist($lieu);
            }
        }
        $manager->flush();
    }
}
