<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has( name: 'todos')){
            $todos = [
                'achat'=>'Acheter une clé USB',
                'cours'=>'Finaliser mon cours',
                'correction'=>'Corriger mes exames'
            ];
            $session->set('todos', $todos);
            $this->addFlash(type:'info', message:'La liste est initialisée');
        }
        return $this->render('todo/index.html.twig');
    }

    /*add todo*/
    #[Route("/add/{action}/{exemple}", name: 'add.todo')]
    public function addTodo(Request $request, $action, $exemple): RedirectResponse
    {
        $session = $request->getSession();
        if ($session->has(name:'todos')) {
            $todos = $session->get(name:'todos');
            if(isset($todos[$action])){
                $this->addFlash(type:'error', message:"Le todo $action existe déjà");
            } else {
                $todos[$action] = $exemple;
                $this->addFlash(type:'success', message:"Le todo $action a été ajouté avec succès");
                $session->set('todos', $todos);
            }
        } else {
            $this->addFlash(type:'error', message:"La liste n'est pas encore initialisée");
        }
        return $this->redirectToRoute('todo');
    }

    /*update todo*/
    #[Route("/update/{action}/{exemple}", name: 'update.todo')]
    public function updateTodo(Request $request, $action, $exemple): RedirectResponse
    {
        $session = $request->getSession();
        if ($session->has(name:'todos')) {
            $todos = $session->get(name:'todos');
            if(!isset($todos[$action])){
                $this->addFlash(type:'error', message:"Le todo $action n'existe pas");
            } else {
                $todos[$action] = $exemple;
                $this->addFlash(type:'success', message:"Le todo $action a bien été modifié avec succès");
                $session->set('todos', $todos);
            }
        } else {
            $this->addFlash(type:'error', message:"La liste n'est pas encore initialisée");
        }
        return $this->redirectToRoute('todo');
    }

    /*delete todo*/
    #[Route("/delete/{action}", name: 'delete.todo')]
    public function deleteTodo(Request $request, $action): RedirectResponse
    {
        $session = $request->getSession();
        if ($session->has(name:'todos')) {
            $todos = $session->get(name:'todos');
            if(!isset($todos[$action])){
                $this->addFlash(type:'error', message:"Le todo $action n'existe pas");
            } else {
                unset($todos[$action]);
                $session->set('todos', $todos);
                $this->addFlash(type:'success', message:"Le todo $action a bien été modifié avec succès");
            }
        } else {
            $this->addFlash(type:'error', message:"La liste n'est pas encore initialisée");
        }
        return $this->redirectToRoute('todo');
    }

    /*reset todo*/ 
    #[Route("/reset", name: 'reset.todo')]
    public function resetTodo(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('todo');
    }
}