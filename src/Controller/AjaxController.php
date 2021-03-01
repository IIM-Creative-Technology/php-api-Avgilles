<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax", methods={"GET"})
     */
    public function index(ClasseRepository $rep): Response
    {
       $qb = $rep->createQueryBuilder('c')
           ->select('c.nom')
           ->addSelect('c.id')
           ->addSelect('c.annee');

        return $this->json( $qb->getQuery()->getResult() );
    }
}
