<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_VETERINAIRE')]
class PanelEventController extends AbstractController
{
    #[Route('/panel/event', name: 'app_panel_event')]
    public function index(): Response
    {
        return $this->render('panel/event/events.html.twig');
    }

    #[Route('/panel/event/{id}', name: 'app_panel_event_show')]
    public function show(Event $event, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();

            return $this->redirectToRoute('app_panel_event_show', ['id' => $event->getId()]);
        }

        return $this->renderForm('panel/event/event.html.twig', compact('event', 'form'));
    }
}
