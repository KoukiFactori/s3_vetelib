<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VeterinaireCalendrierController extends AbstractController
{
    #[Route('/veterinaire/calendrier', name: 'app_veterinaire_calendrier')]
    public function index(): Response
    {
        return $this->render('veterinaire/calendrier/index.html.twig');
    }
}
