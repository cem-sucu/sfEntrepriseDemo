<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

        //le findby fait ici : SELECT * FROM entreprise ORDER BY raisonSociale ASC
        $entreprises = $EntrepriseRepository->findBy([], ["raisonSociale"=>"ASC"]);
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises
        ]);
    }

  
    // la route ici ya un ordre de priorité exemple ici entreprise/new doit passé avant entrprise/id
    // et ne pas oublier d'importer Request -> choisir le httpFoundation
    #[Route('/entreprise/new/', name: 'new_entreprise')]
    //avec cette route on peut diriger pour faire de l'édition, le id ici c'est pour edit une entreprisde en particulier
    #[Route('/entreprise/{id}/edit', name: 'edit_entreprise')]
    public function new_edit(Entreprise $entreprise = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // si l'netreprise n'existe pas on va creer une nouvelle
        if(!$entreprise){
            $entreprise = new Entreprise();
        }
        

        $form = $this->createForm(EntrepriseType::class, $entreprise);

        // ici on place le traitement du formulaire et on ajoute en même temps EntityManagerInterface $entityManager dans "" et on importe
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          
            $entreprise = $form->getData();
            // l'équivalent du prepare en PDO
            $entityManager->persist($entreprise);
            // l'equivalent du execute() en PDO
            $entityManager->flush();

            return $this->redirectToRoute('app_entreprise');
        }

        return $this->render('entreprise/new.html.twig', [
            'formAddEntreprise' => $form,
            //ici en rajoutant edit en renvoyant le ID, on permet de mettre en place un if else pour le titre de l'édition ou l'ajout d'un entreprise
            'edit' => $entreprise->getId()
        ]);
    }  

    #[Route('/entreprise/{id}', name: 'delete_entreprise')]
    public function delete(Entreprise $entreprise, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($entreprise);
        $entityManager->flush();

        return $this->redirectToRoute('app_entreprise');
    }
    
    
    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show(Entreprise $entreprise) : Response {
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise
        ]);
    }
}


