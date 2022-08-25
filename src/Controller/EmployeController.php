<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    #[Route('/ajouter-un-employe', name: 'create_employe', methods: ['GET', 'POST'])]
    public function createEmploye(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $employer = new Employe();

        $form = $this->createForm(EmployeFormType::class);

        return $this->render('employe/employe.html.twig', [
            'form_employe' => $form->createView()
        ]);
    }
}