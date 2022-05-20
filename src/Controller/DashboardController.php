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
    // USERS
    #[Route('/', name: 'index')]

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


    // CLIENTS
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


    // MY PROFILE
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
 
        if($request->request->get('filter_client_month')) {
            $tasks = $tr->filter_client_month(
                $request->request->get('month'),
                $cr->find($request->request->get('client'))
            );
        }

        if($request->request->get('reset')){
            $tasks = $userProfile->getTasks();
        }
        
        return $this->render('dashboard/myProfile.html.twig', [
            'user' => $userProfile, 
            'tasks' => $tasks, 
            'clients' => $clients, 
            'form' => $form->createView()]);

    }

    // PROFILE USER
    #[Route('profileUser/{id}', name: 'profileUser')]

    public function profileUser($id, UserRepository $ur, TaskRepository $tr, ClientRepository $cr, Request $request, SluggerInterface $si){

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

        if($request->request->get('filter_client_month')) {
            $tasks = $tr->filter_client_month(
                $request->request->get('month'),
                $cr->find($request->request->get('client')),
            );
        }

        if($request->request->get('reset')){
            $tasks = $userProfile->getTasks();
        }
        
        return $this->render('dashboard/profileUserAdmin.html.twig', [
            'user' => $userProfile, 
            'tasks' => $tasks, 
            'clients' => $clients, 
            'form' => $form->createView()]);

    }

    // PROFILE CLIENT
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

        if($request->request->get('filter_user_month')) {
            $tasks = $tr->filter_user_month(
                $request->request->get('month'),
                $ur->find($request->request->get('user'))
            );
        }

        if($request->request->get('reset')){
            $tasks = $clientProfile->getTasks();
        }

        return $this->render('dashboard/profileClient.html.twig', ['clientProfile' => $clientProfile, 'tasks' => $tasks, 'clients' => $clients, 'users' => $users, 'form' => $form->createView()]);
    }

    // DELETE USER AND CLIENT
    #[Route('delete/{id}', name: 'deleteUser')]

    public function deleteUser($id, UserRepository $ur, ClientRepository $cr, Request $request){
        
        $userDelete = $ur->find($id);
        $clientDelete = $cr->find($id);
        $action = $request->query->get('action');

        if($action == 'delete_user'){
            $ur->remove($userDelete);
            $users = $ur->findAll();
            return $this->redirectToRoute('dashboard_index');

        }elseif ($action == 'delete_client'){
            $cr->remove($clientDelete);
            $clients = $cr->findAll();
            return $this->redirectToRoute('dashboard_clients');

        }else{
            throw $this->createNotFoundException('Product not found.');
        }

    }


    // EDIT TASK
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

    // ADD TASK
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







}
