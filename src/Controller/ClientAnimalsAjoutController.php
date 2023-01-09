<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientAnimalsAjoutController extends AbstractController
{
    #[Route('/mon_profil/animal/add', name: 'app_client_animals_ajout')]
    public function index(): Response
    {
        return $this->render('client/client_animals/client_animals_ajout/index.html.twig', [
            'controller_name' => 'ClientAnimalsAjoutController',
        ]);
    }
}
