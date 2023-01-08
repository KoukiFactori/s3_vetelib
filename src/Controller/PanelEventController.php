<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanelEventController extends AbstractController
{
    #[Route('/panel/event', name: 'app_panel_event')]
    public function index(): Response
    {
        return $this->render('panel/event/index.html.twig');
    }
}
