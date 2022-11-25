<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NousConnaitreController extends AbstractController
{
    #[Route('/nousconnaitre', name: 'app_nous_connaitre')]
    public function index(): Response
    {
        return $this->render('nous_connaitre/index.html.twig', [
            'controller_name' => 'NousConnaitreController',
        ]);
    }
}
