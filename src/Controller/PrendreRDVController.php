<?php

namespace App\Controller;

use App\Repository\EspeceRepository;
use App\Repository\TypeEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrendreRDVController extends AbstractController
{
    #[Route('/prendre/rdv', name: 'app_prendre_rdv')]
    public function index(EspeceRepository $especeRepo, TypeEventRepository $typeEventRepo): Response
    {
        $especes = $especeRepo->getAll();
        $typeEvents = $typeEventRepo->getAll();

        return $this->render('prendre_rdv/index.html.twig', compact("especes", "typeEvents"));
    }
}
