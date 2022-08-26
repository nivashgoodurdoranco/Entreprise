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

            return $this->redirectToRoute('show_employe');

        }

        return $this->render('employe/employe.html.twig', [
            'form_employe' => $form->createView()
        ]);
    }


    #[Route('/montrer-un-employe', name: 'show_employe')]
    public function showEmploye(EntityManagerInterface $entityManagerInterface): Response
    {
        $employes = $entityManagerInterface->getRepository(Employe::class)->findAll();


        return $this->render('employe/show_employe.html.twig', [
            'employes' => $employes
        ]);
    }

    #[Route('/modifier-un-employe/{id}/', name: 'edit_employe')]
    public function editEmploye(EntityManagerInterface $entityManagerInterface, Employe $employe, request $request): Response
    {
        $form = $this->createForm(EmployeFormType::class, $employe);

        $form->handleRequest($request);

        // Si le formulaire est envoyé et n'a pas d'erreur
        if($form->isSubmitted() && $form->isValid()){

            // Sauvegarde des changements faits dans l'article via le manager général des entités
            $entityManagerInterface->flush();


            // Redirection vers la page de l'article modifié
            return $this->redirectToRoute('show_employe');

        }

        // Appel de la vue en lui envoyant le formulaire à afficher
        return $this->render('employe/edit_employe.html.twig', [
            'form_employe' => $form->createView()
        ]);
    }

    #[Route('/supprimer-un-employe/{id}/', name: 'delete_employe')]
    public function deleteEmploye(EntityManagerInterface $em, Employe $employe, Request $request): Response
    {
        // Suppression de l'article via le manager général des entités
        $em->remove($employe);
        $em->flush();

        return $this->redirectToRoute('show_employe');
    }
}
