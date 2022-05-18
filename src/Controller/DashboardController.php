<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Client;
use App\Form\TaskType;
use App\Form\UsersType;
use App\Form\ClientType;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/a6e5e86abaa90ba7233c262ff0fc99f0', name: 'dashboard_')]
// #[IsGranted('IS_AUTHENTICATED_FULLY')]

class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    // #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $ur, Request $request, SluggerInterface $si): Response
    {
        $users = $ur->findAll();

        $newUser = new User();

        $form = $this->createForm(UsersType::class, $newUser);
        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()){
            $product = $form->getData();
            $imageFile = $form->get('avatar')->getData();

            if($imageFile){
                $orgFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $si->slug($orgFileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                
                try{
                    $imageFile->move(
                        $this->getParameter('user_profile_image'),
                        $newFilename
                    );
                } catch(FileException $e){
                    return new Response('File upload error:'. $e);
                }
                
                $newUser->setAvatar($newFilename);
            }

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

    public function clients(ClientRepository $cr, Request $request, SluggerInterface $si){

        $clients = $cr->findAll();
        $newClient = new Client();

        $form = $this->createForm(ClientType::class, $newClient);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $newClient = $form->getData();

            $imageFile = $form->get('avatar')->getData();

            if($imageFile){
                $orgFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $si->slug($orgFileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                
                try{
                    $imageFile->move(
                        $this->getParameter('user_profile_image'),
                        $newFilename
                    );
                } catch(FileException $e){
                    return new Response('File upload error:'. $e);
                }
                
                $newClient->setAvatar($newFilename);
            }
            $cr->add($newClient);

            return $this->redirectToRoute('dashboard_clients');
            
        }
        return $this->render('dashboard/clients.html.twig', ['clients' => $clients, 'form' => $form->createView()]);
    }


    
    #[Route('myProfile/{id}', name: 'myProfile')]

    public function profile($id, UserRepository $ur, TaskRepository $tr, ClientRepository $cr, Request $request, SluggerInterface $si){

        $userProfile = $ur->find($id);
        $tasks = $userProfile->getTasks();
        $clients = $cr->findAll();

        $form = $this->createForm(UsersType::class, $userProfile);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $userProfile = $form->getData();

            $imageFile = $form->get('avatar')->getData();

            if($imageFile){
                $orgFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $si->slug($orgFileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                
                try{
                    $imageFile->move(
                        $this->getParameter('user_profile_image'),
                        $newFilename
                    );
                } catch(FileException $e){
                    return new Response('File upload error:'. $e);
                }
                
                $userProfile->setAvatar($newFilename);
            }


            $ur->add($userProfile);

            return $this->redirectToRoute('dashboard_index');
        }

        // if($request->request->get('filter_client_month')) {
        //     $tasks = $this->tr->filter_client_month(
        //         $request->request->get('month'),
        //         $this->cr->find($request->request->get('client')),
        //     );
        // }

        if($request->request->get('reset-page')){
            // $tasks = $user->getTasks();
        }
        
        return $this->render('dashboard/myProfile.html.twig', [
            'user' => $userProfile, 
            'tasks' => $tasks, 
            'clients' => $clients, 
            'form' => $form->createView()]);

    }


    #[Route('profieClient/{id}', name: 'clientProfile')]

    public function clientProfie($id, ClientRepository $cr, TaskRepository $tr, UserRepository $ur, Request $request, SluggerInterface $si){

        $clientProfile = $cr->find($id);
        $tasks = $clientProfile->getTasks();
        $users = $ur->findAll();
        $clients = $cr->findAll();

        $form = $this->createForm(ClientType::class, $clientProfile);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $clientProfile = $form->getData();

            $imageFile = $form->get('avatar')->getData();

            if($imageFile){
                $orgFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $si->slug($orgFileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                
                try{
                    $imageFile->move(
                        $this->getParameter('user_profile_image'),
                        $newFilename
                    );
                } catch(FileException $e){
                    return new Response('File upload error:'. $e);
                }
                
                $clientProfile->setAvatar($newFilename);
            }
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


    // #[Route('edit/{id}', name: 'edit', methods: ['GET', 'PUT'])]

    // public function edit($id, UserRepository $ur, Request $request){

    //     $userEdit = $ur->find($id);
    //     $users = $ur->findAll();
    //     $action = $request->query->get('action');

    //     return $this->render('dashboard/index.html.twig', [ 'users' => $users]); 

    // }


    #[Route('/editTask/{id}', name: 'editTask')]

    public function editTask($id, UserRepository $ur,TaskRepository $tr, ClientRepository $cr, Request $request, Security $security){

        $clients = $cr->findAll();
        $task = $tr->find($id);

        $userIdLog = $task->getUser()->getId();
        $user = $ur->find($userIdLog);
        
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $editTask = $form->getData();
            $tr->add($editTask,true);
            
            return $this->redirectToRoute('dashboard_myProfile', ['id' => $userIdLog]);
        }

        return $this->render('dashboard/editTaskAdmin.html.twig', ['form' => $form->createView()]);


    }

    #[Route('addTask/{id}', name: 'addTask')]

    public function addTask($id, TaskRepository $tr, ClientRepository $cr, UserRepository $ur, Request $request){

        $clients = $cr->findAll();
        $user = $ur->find($id);

        $newTask = new Task();

        $form = $this->createForm(TaskType::class, $newTask);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $newTask = $form->getData();
            $newTask->setUser($user);
            $tr->add($newTask);

            return $this->redirectToRoute('dashboard_myProfile', ['id' => $id]);
        }

        return $this->render('dashboard/addTaskAdmin.html.twig', [ 'form' => $form->createView()]);
        
    }

    
    #[Route('/addTask/client/{id}', name: 'addTaskClient')]

    public function addTaskClient($id, TaskRepository $tr,  UserRepository $ur, Request $request, Security $security){

        $client = $ur->find($id);
        $newTask = new Task();
        $user = $security->getUser();
        $user = $ur->findOneBy(['email' => $user->getUserIdentifier()]);
        $userId = $user->getId();

        $form = $this->createForm(TaskType::class, $newTask);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $newTask = $form->getData();
            $newTask->setUser($user);
            $tr->add($newTask);

            return $this->redirectToRoute('dashboard_myProfile', ['id' => $userId]);
        }

        return $this->render('dashboard/addTaskAdmin.html.twig', [ 'form' => $form->createView()]);
        
    }


    // promeniti u klientima da kada se dodaje novi po defaultu bude izabran klient a i user
    // Ako admin udje da edituje drugog usera neka u edit tasku budu podaci usera a ne ulogovanog 

}
