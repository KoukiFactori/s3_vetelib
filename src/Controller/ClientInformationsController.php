<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ClientInformationsController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/mon_profil', name: 'app_client_informations')]
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $token = $this->tokenStorage->getToken();
        $user = $token->getUser();
        $userId = $user->getId();
        $user = $userRepository->find($userId);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $userRepository->save($user, true);
        }

        return $this->render('client/client_informations/index.html.twig', [
            'form' => $form->createView(), 'controller_name' => 'ClientInformationsController',
        ]);
    }
}
