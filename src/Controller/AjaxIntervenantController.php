<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Intervenant;
use App\Repository\ClasseRepository;
use App\Repository\IntervenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxIntervenantController extends AbstractController
{
    /**
     * @Route("ajax-intervenant-supprimer", name="ajax-intervenant-supprimer")
     */
    public function supprimer(IntervenantRepository $repository, EntityManagerInterface $entityManager){

        $entite = $repository->find($_REQUEST['id']);
        $entityManager->remove($entite);

        $entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Route("ajax-intervenant-modifier", name="ajax-intervenant-modifier")
     */
    public function modifier(IntervenantRepository $repository, EntityManagerInterface $entityManager){

        $entite = $repository->find($_REQUEST['id']);
        $entite->setNom($_REQUEST['nom']);
        $entite->setAnneeArrivee($_REQUEST['anneeArrivee']);
        $entite->setPrenom($_REQUEST['prenom']);

        $entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Route("ajax-intervenant-ajouter", name="ajax-intervenant-ajouter")
     */
    public function ajouter(EntityManagerInterface  $entityManager){

        $entite = new Intervenant();
        $entite->setNom($_REQUEST['nom']);
        $entite->setAnneeArrivee($_REQUEST['anneeArrivee']);
        $entite->setPrenom($_REQUEST['prenom']);

        $entityManager->persist($entite);
        $entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Route("ajax-intervenant-lister", name="ajax-intervenant-lister")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $q = $em->createQuery(
            "SELECT  e.id, e.prenom, e.nom, e.anneeArrivee FROM App:Intervenant e");

        return $this->json( $q->getResult() );
    }
}
