<?php

namespace App\DataFixtures;

use App\Entity\Intervenant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class IntrervenantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $f = Factory::create();
        for($j=0;$j<20;$j++){
            $i = new Intervenant();
            $i->setAnneeArrivee($f->year);
            $i->setNom($f->lastName);
            $i->setPrenom($f->firstName);

            $manager->persist($i);
        }

        $manager->flush();
    }
}
