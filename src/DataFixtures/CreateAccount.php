<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAccount extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $roles[] = 'ROLE_USER';

        $participant = new Participant();
        $participant->setMail("riquelme.manuel@hotmail.com");
        $participant->setPrenom("Manuel");
        $participant->setNom("Riquelme");
        $participant->setPassword('$2y$13$l2DYTcwQdOjMImhRWmYK7eQm7sc1NS0g3Dmp1awjud5aMKR9Jkmgq');
        $participant->setRoles($roles);
        $participant->setActif(true);
        $participant->setPseudo("Manu");
        $participant->setTelephone("0649384245");
        $manager->persist($participant);
        $manager->flush();
    }
}

