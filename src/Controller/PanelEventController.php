<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
