<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientAnimalsController extends AbstractController
{
    #[Route('/client/animals', name: 'app_client_animals')]
    public function index(AnimalRepository $ar): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_CLIENT');

        //$clientId=$this->getUser()->Id;
        $animals=$ar->getAllAnimalsByClient(23);

        return $this->render('client/client_animals/index.html.twig', ['animals' => $animals] );
    
    }
}
