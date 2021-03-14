<?php

namespace App\Controller;

use App\Entity\Note;
use App\Repository\EtudiantRepository;
use App\Repository\MatiereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxNoteController extends AbstractController
{
    /**
     * @Route("ajax-note-ajouter", name="ajax-ajouter-note")
     */
    public function ajouter(
        EntityManagerInterface  $entityManager, MatiereRepository $matiereRepository,EtudiantRepository  $etudiantRepository, Request $request){

        $etudiant = $etudiantRepository->find( $_REQUEST['etudiantId'] );
        $matiere = $matiereRepository->find( $_REQUEST['matiereId'] );

        $note = new Note();
        $note->setEtudiant($etudiant);
        $note->setMatiere($matiere);
        $note->setResultat( $_REQUEST['resultat'] );

        $entityManager->persist($note);
        $entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Route("ajax-note-lister", name="ajax-note-lister")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $q = $em->createQuery(
            "SELECT  n.id, n.resultat, e.nom, e.prenom, m.nom
                FROM    App:Note n
                        JOIN n.etudiant e
                        JOIN n.matiere m");

        return $this->json( $q->getResult() );
    }
}
