<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'path' => '    '
        ]);
    }

    #[Route('/template', name: 'template')]
    public function template(): Response
    {
        return $this->render('template.html.twig');
    }

//    #[Route('/hello/{name}/{firstname}', name: 'hello')]
    public function sayHello(Request $request, $name, $firstname): Response
    {
        return $this->render('home/index.html.twig', [
            'nom'=>$name,
            'prenom'=>$firstname
        ]);
    }
}
