<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    #[Route('/livre', name: 'app_livre')]
    public function index(): Response
    {
        return $this->render('livre/index.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }

    #[Route('/AddFormAuthors', name: 'apps5_author')]
    public function AddFormAuthors(ManagerRegistry $manager, Request $request): Response
    {    
        $em = $manager->getManager();
        $livre = new Livre();

        // Create the form
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($livre);
            $em->flush();

            // Redirect or add a success message
            return $this->redirectToRoute('app_livre');
        }

        // Render the form
        return $this->renderForm('livre/insert.html.twig', [
            'formadd' => $form,
        ]);
    }
    #[Route('/RemoveFormAuthors/{id}', name: 'apps7_author')]
    public function RemoveFormAuthors(ManagerRegistry $manager,$id): Response
    {    
        $em=$manager->getManager();
        $livre=$em->getRepository(Livre::class)->find($id);
        $em->remove($livre);
        $em->flush();
        return $this->redirect('/livre');
    }
    #[Route('/list', name: 'apps5_author')]
    public function liste(LivreRepository $livreRepository): Response
    {    
        $livre=$livreRepository->findAll();
        return $this->render('livre/show.html.twig', [
            'controller_name' => 'LivreController',
            'livres' => $livre,
        ]);
    }
}
