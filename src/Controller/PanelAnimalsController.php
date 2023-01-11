<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Veterinaire;
use App\Repository\AnimalRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_VETERINAIRE')]
class PanelAnimalsController extends AbstractController
{
    #[Route('/panel/animal', name: 'app_panel_animal')]
    public function index(AnimalRepository $repository): Response
    {
        /**
         * @var Veterinaire
         */
        $user = $this->getUser();

        $animals = $repository->fetchAnimalsWithExtraData($user->getId());

        return $this->render('panel/animal/animals.html.twig', [
            "animals" => $animals
        ]);
    }

    #[Route('/panel/animal/{id}', name: 'app_panel_animal_show')]
    public function show(Animal $animal): Response
    {
        return $this->render('panel/animal/animal.html.twig', ["client" => $animal]);
    }
}
