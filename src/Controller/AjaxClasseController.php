<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Note;
use App\Repository\ClasseRepository;
use App\Repository\EtudiantRepository;
use App\Repository\MatiereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxClasseController extends AbstractController
{
    /**
     * @Route("ajax-classe-supprimer", name="ajax-classe-supprimer")
     */
    public function supprimer(ClasseRepository $classeRepository, EntityManagerInterface $entityManager){

        $classe = $classeRepository->find($_REQUEST['id']);
        $entityManager->remove($classe);

        $entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Route("ajax-classe-modifier", name="ajax-classe-modifier")
     */
    public function modifier(ClasseRepository $classeRepository, EntityManagerInterface $entityManager){

        $classe = $classeRepository->find($_REQUEST['id']);
        $classe->setNom($_REQUEST['nom']);
        $classe->setAnnee($_REQUEST['annee']);

        $entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Route("ajax-classe-ajouter", name="ajax-classe-ajouter")
     */
    public function ajouter(EntityManagerInterface  $entityManager){

        $classe = new Classe();
        $classe->setNom($_REQUEST['nom']);
        $classe->setAnnee($_REQUEST['annee']);

        $entityManager->persist($classe);
        $entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Route("ajax-classe-lister", name="ajax-classe-lister")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $q = $em->createQuery(
            "SELECT  c.id, c.nom, c.annee FROM App:Classe c");

        return $this->json( $q->getResult() );
    }
}
