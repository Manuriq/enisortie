<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AddCampus extends Fixture
{

    public const CAMPUS_USER_REFERENCE = 'campus-user';
    public function load(ObjectManager $manager): void
    {
        $campus = new Campus();
        $campus->setNom("ENI Ecole");
        $manager->persist($campus);
        $manager->flush();
        $this->addReference(self::CAMPUS_USER_REFERENCE, $campus);
    }
}
