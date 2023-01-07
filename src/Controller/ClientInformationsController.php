<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientInformationsController extends AbstractController
{
    #[Route('/client/informations/{user}', name: 'app_client_informations', requirements: ['user' => "\d+"])]
    public function index(User $user, Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $userRepository->save($user, true);
        }
        // $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $clientId = $this->getUser()->id;

        return $this->render('client/client_informations/index.html.twig', [
            'form' => $form->createView(), 'controller_name' => 'ClientInformationsController',
        ]);
    }
}
