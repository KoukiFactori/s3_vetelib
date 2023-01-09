<?php

namespace App\Controller;

use App\Repository\EspeceRepository;
use App\Repository\EventRepository;
use App\Repository\TypeEventRepository;
use App\Repository\VeterinaireRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrendreRDVController extends AbstractController
{
    #[Route('/prendre/rdv', name: 'app_prendre_rdv')]
    public function index(EspeceRepository $especeRepo, TypeEventRepository $typeEventRepo, VeterinaireRepository $vetoRepo): Response
    {
        $especes = $especeRepo->getAll();
        $typeEvents = $typeEventRepo->getAll();
        $vetoAndEvents = $vetoRepo->getEventsOn(new DateTime());
        $slots = $vetoRepo->getAvailableSlots($vetoAndEvents);

        return $this->render('prendre_rdv/index.html.twig',[
            'especes' => $especes,
            'typeEvents' => $typeEvents,
            'vetos' => $vetoAndEvents,
            'slots' => $slots
        ]);
    }
}
