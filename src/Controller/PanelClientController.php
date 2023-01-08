<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\EventType;
use App\Repository\ClientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_VETERINAIRE')]
class PanelClientController extends AbstractController
{
    #[Route('/panel/client', name: 'app_panel_client')]
    public function index(ClientRepository $repository): Response
    {
        $clients = $repository->findAll();

        return $this->render('panel/client/clients.html.twig', [
            "clients" => $clients 
        ]);
    }

    #[Route('/panel/client/{id}', name: 'app_panel_client_show')]
    public function show(Client $client): Response
    {
        return $this->render('panel/client/client.html.twig', ["client" => $client]);
    }
}
