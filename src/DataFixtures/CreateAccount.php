<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use DateTimeImmutable;
use App\Entity\Participant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAccount extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $dateImmutable = new DateTimeImmutable("now");

        $participant = new Participant();
        $participant->setMail("riquelme.manuel@hotmail.com");
        $participant->setPrenom("Manuel");
        $participant->setNom("Riquelme");
        $participant->setMotPasse('$2y$13$s9jUFkujuUP4/GH2upsKHevtiaW2fsCyXCpKNbPT8QPYn4js22SE6');
        $participant->setAdministrateur(true);
        $participant->setActif(true);
        $participant->setPseudo("Manu");
        $participant->setTelephone("0649384245");
        $participant->setUpdatedAt($dateImmutable);
        $participant->setCampus($this->getReference(AddCampus::CAMPUS_USER_REFERENCE));
        $manager->persist($participant);

        $participant2 = new Participant();
        $participant2->setMail("aurelien.robin@hotmail.com");
        $participant2->setPrenom("Aurélien");
        $participant2->setNom("Robin");
        $participant2->setMotPasse('$2y$13$iGVUNIdUR2.7tQ10ka1R3uv0ThtX3lHoP5.05DfKxqvaTJXWKFwna'); //123456
        $participant2->setAdministrateur(false);
        $participant2->setActif(true);
        $participant2->setPseudo("Athalfrid");
        $participant2->setTelephone("0123456789");
        $participant2->setUpdatedAt($dateImmutable);
        $participant2->setCampus($this->getReference(AddCampus::CAMPUS_USER_REFERENCE));
        $manager->persist($participant2);

        $manager->flush();
    }
}

