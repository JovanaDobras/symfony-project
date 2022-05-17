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
        $tasks = $tr->findAll();
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

    public function editTask($id, UserRepository $ur,TaskRepository $tr, ClientRepository $cr){

        $userProfile = $ur->findAll();
        $tasks = $tr->findAll();
        $editTask = $ur->find($id);
        $clients = $cr->findAll();
        // dd($editTask);


        // $form = $this->createForm(TaskType::class, $editTask);
        // $form->handleRequest($editTask);

        // if($form->isSubmitted() && $form->isValid()){
        //     $editTask = $form->getData();
        //     $ur->add($editTask);

        //     return $this->redirectToRoute('dashboard_user_myProfile');
        // }

        return $this->render('user/editTask.html.twig', ['user' => $editTask, 'tasks' => $tasks, 'clients' => $clients]);


    }


}
