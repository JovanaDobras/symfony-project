<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Form\UsersType;
use App\Form\ClientType;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/a6e5e86abaa90ba7233c262ff0fc99f0', name: 'dashboard_')]
// #[IsGranted('IS_AUTHENTICATED_FULLY')]

class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    // #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $ur, Request $request): Response
    {
        $users = $ur->findAll();

        $newUser = new User();

        $form = $this->createForm(UsersType::class, $newUser);
        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()){
            $product = $form->getData();
            $ur->add($product);

            return $this->redirectToRoute('dashboard_index');

        }

        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('dashboard_user_myProfile');
        }else{
            return $this->render('dashboard/index.html.twig', ['users' => $users, 'form' => $form->createView()]);
        }
    }



    #[Route('clients', name: 'clients')]

    public function clients(ClientRepository $cr, Request $request){

        $clients = $cr->findAll();
        $newClient = new Client();

        $form = $this->createForm(ClientType::class, $newClient);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $newClient = $form->getData();
            $cr->add($newClient);

            return $this->redirectToRoute('dashboard_clients');
            
        }
        return $this->render('dashboard/clients.html.twig', ['clients' => $clients, 'form' => $form->createView()]);
    }


    
    #[Route('myProfile/{id}', name: 'myProfile')]

    public function profile($id, UserRepository $ur, TaskRepository $tr, ClientRepository $cr, Request $request){

        $userProfile = $ur->find($id);
        $tasks = $tr->findAll();
        $clients = $cr->findAll();

        $form = $this->createForm(UsersType::class, $userProfile);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $userProfile = $form->getData();
            $ur->add($userProfile);

            return $this->redirectToRoute('dashboard_index');
        }
        
        return $this->render('dashboard/myProfile.html.twig', ['user' => $userProfile, 'tasks' => $tasks, 'clients' => $clients, 'form' => $form->createView()]);

    }


    #[Route('profieClient/{id}', name: 'clientProfile')]

    public function clientProfie($id, ClientRepository $cr, TaskRepository $tr, UserRepository $ur, Request $request){

        $clientProfile = $cr->find($id);
        $tasks = $tr->findAll();
        $users = $ur->findAll();
        $clients = $cr->findAll();

        $form = $this->createForm(ClientType::class, $clientProfile);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $clientProfile = $form->getData();
            $cr->add($clientProfile);

            return $this->redirectToRoute('dashboard_clients');
        }

        return $this->render('dashboard/profileClient.html.twig', ['clientProfile' => $clientProfile, 'tasks' => $tasks, 'clients' => $clients, 'users' => $users, 'form' => $form->createView()]);
    }


    #[Route('delete/{id}', name: 'deleteUser')]

    public function deleteUser($id, UserRepository $ur, ClientRepository $cr, Request $request){
        
        $userDelete = $ur->find($id);
        $clientDelete = $cr->find($id);
        $action = $request->query->get('action');

        if($action == 'delete_user'){
            $ur->remove($userDelete);
            $users = $ur->findAll();
            return $this->render('dashboard/index.html.twig', ['users' => $users]);

        }elseif ($action == 'delete_client'){
            $cr->remove($clientDelete);
            $clients = $cr->findAll();
            return $this->render('dashboard/clients.html.twig', ['clients' => $clients]);

        }else{
            throw $this->createNotFoundException('Product not found.');
        }

    }


    #[Route('edit/{id}', name: 'edit', methods: ['GET', 'PUT'])]

    public function edit($id, UserRepository $ur, Request $request){

        $userEdit = $ur->find($id);
        $users = $ur->findAll();
        $action = $request->query->get('action');

        // $form = $this->createForm(UsersType::class, $userEdit, ['method' => 'PUT']);
        // $form->handleRequest($request);

        // if($form->isSubmitted() && $form->isValid()){

        //     $userEdit = $form->getData();
        //     $ur->add($userEdit);

        // }
        return $this->render('dashboard/index.html.twig', [ 'users' => $users]); 

    }

}
