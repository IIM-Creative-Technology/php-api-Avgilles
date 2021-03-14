<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Repository\ClasseRepository;
use App\Repository\EtudiantRepository;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxEtudiantController extends AbstractController
{
    /**
     * @Route("ajax-etudiant-ajouter", name="ajax-etudiant-ajouter")
     */
    public function ajouter(
        EntityManagerInterface $entityManager, ClasseRepository $classeRepository, NoteRepository $noteRepository, Request $request){

        $classe = $classeRepository->find($_REQUEST['idClasse']);

        $etudiant = new Etudiant();

        $etudiant-> setNom($_REQUEST['nom']);
        $etudiant-> setPrenom($_REQUEST['prenom']);
        $etudiant-> setAge($_REQUEST['age']);
        $etudiant-> setAnneeArrivee($_REQUEST['anneeArrivee']);
        $etudiant->setClasse($classe);

        $entityManager->persist($etudiant);
        $entityManager->flush();

        return $this->json("Element ajoute");

    }

    /**
     *@Route ("ajax-etudiant-supprimer",name="ajax-etudiant-supprimer")
     */
    public function supprimer(EtudiantRepository $repository, EntityManagerInterface $entityManager){

        $etudiant = $repository ->find($_REQUEST['id']);

        foreach($etudiant->getNotes() as $note){
            $entityManager->remove($note);
        }

        $entityManager->remove($etudiant);

        $entityManager-> flush();
        return $this->json("data supprimer");

    }
    /**
     *@Route ("ajax-etudiant-modifier",name="ajax-etudiant-modifier")
     */
    public function modifier(EtudiantRepository $repository, EntityManagerInterface $entityManager){

        $etudiant = $repository->find($_REQUEST['id']);
        $etudiant->setNom($_REQUEST['nom']);
        $etudiant->setPrenom($_REQUEST['prenom']);
        $etudiant->setAge($_REQUEST['age']);
        $etudiant->setAnneeArrivee($_REQUEST["anneeArrivee"]);

        $entityManager->flush();

        return $this->json("OK");

    }

    /**
     * @Route("ajax-etudiant-lister", name="ajax-etudiant-lister")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $q = $em->createQuery(
            "SELECT   e.id, e.nom, e.prenom , e.age , e.anneeArrivee
                  FROM    App:Etudiant e
                          JOIN e.classe c
                  ORDER BY e.nom, e.prenom");
        return $this->json( $q->getResult() );
    }
}
