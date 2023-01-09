<?php

namespace App\Controller;

use App\Form\NewEventType;
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
    public function index(VeterinaireRepository $vetoRepo, Request $request): Response
    {
        $form = $this->createForm(NewEventType::class, options: [
            'clientId' => $this->getUser()->getId()
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $vetoAndEvents = $vetoRepo->getEventsOn($formData['date']);
            $slots = $vetoRepo->getAvailableSlots($vetoAndEvents);

            return $this->renderForm('prendre_rdv/index.html.twig', [
                'hasSubmitted' => true,
                'vetos' => $vetoAndEvents,
                'slots' => $slots,
                'selectedAnimal' => $formData['animal'],
                'selectedTypeEvent' => $formData['typeEvent'],
                'selectedDescription' => $formData['description'],
                'form' => $form
            ]);
        }

        return $this->renderForm('prendre_rdv/index.html.twig', [
            'hasSubmitted' => false,
            'form' => $form
        ]);
    }
}
