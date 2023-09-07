<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Repository\EmployeRepository;
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

    // toujour cliqure droit importer class : ici en l'occurence importer Employe
    #[Route('/employe/{id}', name: 'show_employe')]
    public function show(Employe $employe) : Response {
        return $this->render('employe/show.html.twig', [
            'employe' => $employe
        ]);
    }
}
