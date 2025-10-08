<?php

# Generated using the make:crud command

namespace App\Controller;

use App\Entity\Garden;
use App\Form\GardenType;
use App\Repository\GardenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/garden')]
final class GardenController extends AbstractController
{
    #[Route(name: 'app_garden_index', methods: ['GET'])]
    public function index(GardenRepository $gardenRepository): Response
    {
        return $this->render('garden/index.html.twig', [
            'gardens' => $gardenRepository->findAll(),
        ]);
    }

   
# Create Garden
    #[Route('/new', name: 'app_garden_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $garden = new Garden();
        $form = $this->createForm(GardenType::class, $garden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($garden);
            $entityManager->flush();

            return $this->redirectToRoute('app_garden_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('garden/new.html.twig', [
            'garden' => $garden,
            'form' => $form,
        ]);
    }
    
# Show Garden/id
    #[Route('/{id}', name: 'app_garden_show', methods: ['GET'])]
    public function show(Garden $garden): Response
    {
        return $this->render('garden/show.html.twig', [
            'garden' => $garden,
        ]);
    }
    
    
# Edit Garden
    #[Route('/{id}/edit', name: 'app_garden_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Garden $garden, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GardenType::class, $garden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_garden_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('garden/edit.html.twig', [
            'garden' => $garden,
            'form' => $form,
        ]);
    }

# Delete Garden
    #[Route('/{id}', name: 'app_garden_delete', methods: ['POST'])]
    public function delete(Request $request, Garden $garden, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garden->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($garden);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_garden_index', [], Response::HTTP_SEE_OTHER);
    }



# List bird inside a Garden 
    #[Route('/{id}/birds', name: 'app_garden_birds', methods: ['GET'])]
    public function show_birds(Garden $garden): Response 
    {
        $birds = $garden->getBirds();
        
        return $this->render('garden/show_birds.twig', [
            'garden' => $garden,
            'birds' => $birds]);
    }
}
