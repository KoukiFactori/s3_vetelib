<?php

namespace App\Controller;

use App\Repository\EspeceRepository;
use App\Repository\TypeEventRepository;
use App\Repository\VeterinaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrendreRDVController extends AbstractController
{
    #[Route('/prendre/rdv', name: 'app_prendre_rdv')]
    public function index(EspeceRepository $especeRepo, TypeEventRepository $typeEventRepo, VeterinaireRepository $vetoRepo, Request $request): Response
    {
        $especes = $especeRepo->getAll();
        $typeEvents = $typeEventRepo->getAll();
        $vetoAndEvents = $vetoRepo->getEventsOn(new \DateTime());
        $slots = $vetoRepo->getAvailableSlots($vetoAndEvents);

        return $this->render('prendre_rdv/index.html.twig', [
            'selectedEspece' => $request->get('espece'),
            'selectedDate' => (new \DateTime())->format('d/m/Y'),
            'selectedTypeEvent' => $request->get('typeEvent'),
            'especes' => $especes,
            'typeEvents' => $typeEvents,
            'vetos' => $vetoAndEvents,
            'slots' => $slots,
        ]);
    }
}
