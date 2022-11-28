<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestLayoutController extends AbstractController
{
    #[Route('/test/layout', name: 'app_test_layout')]
    public function index(): Response
    {
        return $this->render('test_layout/index.html.twig', [
            'controller_name' => 'TestLayoutController',
        ]);
    }
}
