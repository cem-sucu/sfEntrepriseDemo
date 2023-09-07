<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(EmployeRepository $employeRepository): Response
    {
        // $employes = $employeRepository->findAll();

        //le findBby ici fait : SELECT * FROM employe ORDER BY nom ASC
        $employes = $employeRepository->findBy([], ["nom"=>"ASC"]);
        return $this->render('employe/index.html.twig', [
            'employes' => $employes
        ]);
    }

    // la route ici ya un ordre de priorité exemple ici employe/new doit passé avant employe/id
    // ne pas oublier d'importer Request -> choisir le httpFoundation
    #[Route('/employe/new/', name: 'new_employe')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $employe = new Employe();

        $form = $this->createForm(EmployeType::class, $employe);

        // ici on place le traitement du formulaire et on ajoute en même temps EntityManagerInterface $entityManager dans "" et on importe
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          
            $employe = $form->getData();
            // l'équivalent du prepare en PDO
            $entityManager->persist($employe);
            // l'equivalent du execute() en PDO
            $entityManager->flush();

            return $this->redirectToRoute('app_employe');
        }

        return $this->render('entreprise/new.html.twig', [
            'formAddEntreprise' => $form,
        ]);

        return $this->render('employe/new.html.twig', [
            'formAddEmploye' => $form
        ]);

    }  


    // toujour cliqure droit importer class : ici en l'occurence importer Employe
    #[Route('/employe/{id}', name: 'show_employe')]
    public function show(Employe $employe) : Response {
        return $this->render('employe/show.html.twig', [
            'employe' => $employe
        ]);
    }
}
