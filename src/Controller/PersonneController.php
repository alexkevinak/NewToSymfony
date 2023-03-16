<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('personne')]
class PersonneController extends AbstractController
{
    #[Route('/', name: 'personne.liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findAll();


        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
        ]);
    }

    #[Route('/alls/{page?1}/{nbr?12}', name: 'personne.liste.alls')]
    public function indexAlls(ManagerRegistry $doctrine, $page, $nbr): Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findBy([], [], $nbr, ($page - 1) * $nbr);

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'personne.detail')]
    public function detail(Personne $personne = null): Response
    {
        if (!$personne){
            $this->addFlash('error', "La personne n'existe pas");
            return $this->redirectToRoute('personne.liste');
        }

        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }

    #[Route('/add', name: 'add.personne')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $personne = new Personne();
        $personne->setName('Alex');
        $personne->setFirstname('Kevin');
        $personne->setAge('21');
        $personne->setJob('Etudiant');

//        $personne2 = new Personne();
//        $personne2->setName('Razanajafy');
//        $personne2->setFirstname('Shandola');
//        $personne2->setAge('22');
//        $personne2->setJob('Etudiante');

        $entityManager->persist($personne);
//        $entityManager->persist($personne2);

        $entityManager->flush();

        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }
}
