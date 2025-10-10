<?php

namespace App\Controller;

use App\Entity\Birds;
use App\Form\BirdsType;
use App\Repository\BirdsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/birds')]
final class BirdsController extends AbstractController
{
    
    //Birds are meant to remain private
/*    #[Route(name: 'app_birds_index', methods: ['GET'])]
    public function index(BirdsRepository $birdsRepository): Response
    {
        return $this->render('birds/index.html.twig', [
            'birds' => $birdsRepository->findAll(),
        ]);
    }
*/
    
    #[Route('/new', name: 'app_birds_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bird = new Birds();
        $form = $this->createForm(BirdsType::class, $bird);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bird);
            $entityManager->flush();

            return $this->redirectToRoute('app_garden_birds', [], Response::HTTP_SEE_OTHER);  //Redirect should be changed for new, edit, delete
        }

        return $this->render('birds/new.html.twig', [
            'bird' => $bird,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_birds_show', methods: ['GET'])]
    public function show(Birds $bird): Response
    {
        return $this->render('birds/show.html.twig', [
            'bird' => $bird,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_birds_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Birds $bird, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BirdsType::class, $bird);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_birds_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('birds/edit.html.twig', [
            'bird' => $bird,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_birds_delete', methods: ['POST'])]
    public function delete(Request $request, Birds $bird, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bird->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bird);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_birds_index', [], Response::HTTP_SEE_OTHER);
    }
}
