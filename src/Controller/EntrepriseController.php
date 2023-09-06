<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


//// ces 2 méthode font la même chose c'est a dire :
    // récupérer toutes les entreprises à partir de la base de données et de les afficher dans un modèle Twig,


class EntrepriseController extends AbstractController
{
    ////////// methode 1

    // #[Route('/entreprise', name: 'app_entreprise')]
    // public function index(EntityManagerInterface $entityManager): Response
    // {
    //     $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();
    //     return $this->render('entreprise/index.html.twig', [
    //         'entreprises' => $entreprises
    //     ]);
    // }



    //////// methode 2 a privilégier 
    
    // on utilise directement EntrepriseRepository qui se crée lorsque l'on crée Entity entreprise et on oublie pas de l'importer
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(EntrepriseRepository $EntrepriseRepository): Response
    {
        // $entreprises = $EntrepriseRepository->findAll();

        //le findby fait ici : SELECT * FROM entreprise WHERE ville = "Strasbourg" ORDER BY raisonSociale ASC
        $entreprises = $EntrepriseRepository->findBy(["ville"=>"STRASBOURG"],["raisonSociale"=>"ASC"]);
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises
        ]);
    }
}


