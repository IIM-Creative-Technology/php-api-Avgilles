<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\Matiere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EtudiantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $f = Factory::create();
        $classes =  $manager->getRepository(Classe::class)->findAll();

        for($i=0;$i<50;$i++){

            shuffle($classes);
            $classe = $classes[0];

            $e = new Etudiant();
            $e->setNom($f->lastName);
            $e->setPrenom($f->firstName);
            $e->setAge($f->numberBetween(17,28));
            $e->setAnneeArrivee($f->numberBetween(2015,2021));
            $e->setClasse($classe);

            $manager->persist($e);


        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
