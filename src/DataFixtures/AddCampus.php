<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AddCampus extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $campus = new Campus();
        $campus->setNom("ENI Ecole");
        $manager->persist($campus);
        $manager->flush();
    }
}
