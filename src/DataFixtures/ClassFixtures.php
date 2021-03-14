<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClassFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $f = Factory::create();
       for($i=0; $i<20; $i++){
           $c= new Classe();
           $c->setNom($f->city);
           $c->setAnnee($f->year);

           $manager->persist($c);

       }

        $manager->flush();
    }
}
