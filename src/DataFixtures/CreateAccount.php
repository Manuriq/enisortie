<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Participant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAccount extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $participant = new Participant();
        $participant->setMail("riquelme.manuel@hotmail.com");
        $participant->setPrenom("Manuel");
        $participant->setNom("Riquelme");
        $participant->setMotPasse('$2y$13$s9jUFkujuUP4/GH2upsKHevtiaW2fsCyXCpKNbPT8QPYn4js22SE6');
        $participant->setAdministrateur(true);
        $participant->setActif(true);
        $participant->setPseudo("Manu");
        $participant->setTelephone("0649384245");
        $participant->setCampus($this->getReference(AddCampus::CAMPUS_USER_REFERENCE));
        $manager->persist($participant);
        $manager->flush();
    }
}

