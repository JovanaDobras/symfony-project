<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/a6e5e86abaa90ba7233c262ff0fc99f0', name: 'dashboard_')]
class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'logout')]
    public function index()
    {
        
        return $this->redirectToRoute('dashboard_login');
    }
}
