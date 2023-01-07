<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig');
    }

    #[Route('/veto', name: 'app_index')]
    public function veto(): Response
    {
        return $this->render('veterinaire/layout/base.html.twig');
    }
}
