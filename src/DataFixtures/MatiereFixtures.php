<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Intervenant;
use App\Entity\Matiere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MatiereFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Récup intervenants et classes
        $intervenants = $manager->getRepository(Intervenant::class)->findAll();
        $classes = $manager->getRepository(Classe::class)->findAll();

        $f= Factory::create();
        for($i=0; $i<20; $i++){

            // Choisit un intervenant
            shuffle($intervenants);
            shuffle($classes);
            $intervenant = $intervenants[0];
            $classe = $classes[0];

            $m= new Matiere();
            $m->setNom($f->company);
            $m->setDateDebut($f->dateTime());
            $m->setDateFin($f->dateTime($m->getDateDebut()));
            $m->setIntervenant($intervenant);
            $m->addClass($classe);
            $manager->persist($m);
        }

        $manager->flush();
    }
}
