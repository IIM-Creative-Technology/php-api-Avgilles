<?php

namespace App\Controller;

use App\Entity\Intervenant;
use App\Entity\Matiere;
use App\Repository\IntervenantRepository;
use App\Repository\MatiereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxMatiereController extends AbstractController
{
    /**
     * @Route("ajax-matiere-supprimer", name="ajax-matiere-supprimer")
     */
    public function supprimer(MatiereRepository $repository, EntityManagerInterface $entityManager){

        $entite = $repository->find($_REQUEST['id']);
        $entityManager->remove($entite);

        $entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Route("ajax-matiere-modifier", name="ajax-matiere-modifier")
     */
    public function modifier(MatiereRepository $repository, EntityManagerInterface $entityManager){

        $entite = $repository->find($_REQUEST['id']);
        $entite->setNom($_REQUEST['nom']);

        $entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Route("ajax-matiere-ajouter", name="ajax-matiere-ajouter")
     */
    public function ajouter(EntityManagerInterface  $entityManager, IntervenantRepository $rep){

        $intervenant = $rep->find($_REQUEST['intervenantId']);

        $entite = new Matiere();
        $entite->setNom($_REQUEST['nom']);
        $entite->setIntervenant($intervenant);
        $entite->setDateDebut(new \DateTime());
        $entite->setDateFin(new \DateTime());

        $entityManager->persist($entite);
        $entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Route("ajax-matiere-lister", name="ajax-matiere-lister")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $q = $em->createQuery(
            "   SELECT  e.id,e.nom,e.dateDebut,e.dateFin,i.prenom prenomIntervenant,i.nom nomIntervenant
                    FROM    App:Matiere e
                            JOIN e.intervenant i
                    ORDER BY e.nom");

        return $this->json( $q->getResult() );
    }
}
