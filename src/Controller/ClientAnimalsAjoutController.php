<?php

namespace App\Controller;

use App\Form\AddAnimalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ClientAnimalsAjoutController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    
    #[Route('/mon_profil/animal/add', name: 'app_client_animals_ajout')]
    public function index(): Response
    {
        $form = $this->createForm(AddAnimalType::class);

        
        return $this->render('client/client_animals/client_animals_ajout/index.html.twig', [
            'form' => $form->createView(), 'controller_name' => 'ClientAnimalsAjoutController',
        ]);
    }
}
