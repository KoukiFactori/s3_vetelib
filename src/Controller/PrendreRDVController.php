<?php

namespace App\Controller;

use App\Repository\EspeceRepository;
use App\Repository\TypeEventRepository;
use App\Repository\VeterinaireRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_CLIENT')]
class PrendreRDVController extends AbstractController
{
    #[Route('/prendre-rdv', name: 'app_prendre_rdv')]
    public function index(EspeceRepository $especeRepo, TypeEventRepository $typeEventRepo, VeterinaireRepository $vetoRepo, Request $request): Response
    {
        $selectedDate = $request->get('date', (new \DateTime())->format('d/m/Y'));
        
        $especes = $especeRepo->getAll();
        $typeEvents = $typeEventRepo->getAll();
        $vetoAndEvents = $vetoRepo->getEventsOn(date_create_from_format('d/m/Y', $selectedDate));
        $slots = $vetoRepo->getAvailableSlots($vetoAndEvents);

        return $this->render('prendre_rdv/index.html.twig', [
            'selectedEspece' => $request->get('espece'),
            'selectedDate' => $selectedDate,
            'selectedTypeEvent' => $request->get('typeEvent'),
            'especes' => $especes,
            'typeEvents' => $typeEvents,
            'vetos' => $vetoAndEvents,
            'slots' => $slots,
        ]);
    }
}
