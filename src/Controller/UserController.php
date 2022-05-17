<?php

namespace App\Controller;

use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use App\Form\UsersType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



#[Route('/user', name: 'dashboard_user_')]

class UserController extends AbstractController
{

    #[Route('/myProfile', name: 'myProfile')]

    public function profile(Request $request, TaskRepository $tr, ClientRepository $cr, Security $security, UserRepository $ur){

        $userProfile = $security->getUser();
        $userProfile = $ur->findOneBy(['email' => $userProfile->getUserIdentifier()]);
        $tasks = $userProfile->getTasks();
        $clients = $cr->findAll();

        $form = $this->createForm(UsersType::class, $userProfile);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $product = $form->getData();
            $ur->add($product);

            return $this->redirectToRoute('dashboard_user_myProfile');

        }

        return $this->render('user/profileUser.html.twig', ['user' => $userProfile, 'tasks' => $tasks, 'clients' => $clients, 'form' => $form->createView()]);

    }

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
            
            return $this->redirectToRoute('dashboard_user_myProfile');
        }

        return $this->render('user/editTask.html.twig', ['task' => $task, 'clients' => $clients, 'form' => $form->createView()]);


    }


}
