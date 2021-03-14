<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\Matiere;
use App\Entity\Note;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NoteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $f= Factory::create();
        $etudiants= $manager->getRepository(Etudiant::class)->findAll();
        $matieres = $manager->getRepository(Matiere::class)->findAll();

        for ($i=0; $i<50; $i++){

            shuffle($etudiants);
            $etudiant = $etudiants[0];

            shuffle($matieres);
            $matiere = $matieres[0];


            $n = new Note();
            $n->setResultat($f->numberBetween(0,20));
            $n-> setEtudiant($etudiant);
            $n-> setMatiere($matiere);

            $manager->persist($n);

        }

        $manager->flush();
    }
}
