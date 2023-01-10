<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\NewEventType;
use App\Repository\AnimalRepository;
use App\Repository\TypeEventRepository;
use App\Repository\VeterinaireRepository;
use Doctrine\Persistence\ManagerRegistry;
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
                'selectedDate' => $formData['date']->format("m/d/Y"),
                'form' => $form
            ]);
        }

        return $this->renderForm('prendre_rdv/index.html.twig', [
            'hasSubmitted' => false,
            'form' => $form
        ]);
    }

    #[Route('/prendre-rdv/create', methods: ['POST'], name: 'app_prendre_rdv_create')]
    public function create(
        Request $request,
        AnimalRepository $animalRepository,
        TypeEventRepository $typeEventRepository,
        VeterinaireRepository $veterinaireRepository,
        ManagerRegistry $doctrine
    ): Response
    {
        $animal = $animalRepository->find($request->get('animal'));
        $typeEvent = $typeEventRepository->find($request->get('typeEvent'));
        $veterinaire = $veterinaireRepository->find($request->get('veto'));

        $event = new Event();
        $event->setDate(date_create_from_format('m/d/Y G:i', $request->get('date') . ' ' . $request->get('slot')));
        $event->setDescription($request->get('description'));
        $event->setAnimal($animal);
        $event->setTypeEvent($typeEvent);
        $event->setVeterinaire($veterinaire);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($event);
        $entityManager->flush();

        return $this->redirectToRoute('app_prendre_rdv');
    }
}
