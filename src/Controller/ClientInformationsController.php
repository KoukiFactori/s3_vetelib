<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientInformationsController extends AbstractController
{
    #[Route('/client/informations', name: 'app_client_informations')]
    public function index(): Response
    {
        return $this->render('client/client_informations/index.html.twig', [
            'controller_name' => 'ClientInformationsController',
        ]);
    }
}
