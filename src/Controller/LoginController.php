<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/a6e5e86abaa90ba7233c262ff0fc99f0', name: 'dashboard_')]

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(AuthenticationUtils $auth): Response
    {
        if($this->getUser())
            return $this->redirectToRoute('dashboard_index');
        
            // vracanje error poruke za neuspelo logovanje
        $error = $auth->getLastAuthenticationError();
        return $this->render('login/index.html.twig', ['error' => $error]);

    }

    #[Route('/test', name: 'test')]
    public function test(): Response
    {

        return new Response('test');


    }
}
