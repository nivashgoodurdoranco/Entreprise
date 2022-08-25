<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeFormType;
use DateTime;
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

        $form = $this->createForm(EmployeFormType::class, $employer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $employer->setCreatedAt(new DateTime());
            $entityManagerInterface->persist($employer);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('default_home');

        }

        return $this->render('employe/employe.html.twig', [
            'form_employe' => $form->createView()
        ]);
    }
}
