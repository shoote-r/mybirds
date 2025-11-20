<?php

namespace App\Controller;

use App\Entity\Aviary;
use App\Form\AviaryType;
use App\Repository\AviaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use App\Entity\Birds;

#[Route('/aviary')]
final class AviaryController extends AbstractController
{
    #[Route(name: 'app_aviary_index', methods: ['GET'])]
    public function index(AviaryRepository $aviaryRepository): Response
    {
        return $this->render('aviary/index.html.twig', [
            'aviaries' => $aviaryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_aviary_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aviary = new Aviary();
        $form = $this->createForm(AviaryType::class, $aviary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aviary);
            $entityManager->flush();

            return $this->redirectToRoute('app_aviary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('aviary/new.html.twig', [
            'aviary' => $aviary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aviary_show', methods: ['GET'])]
    public function show(Aviary $aviary): Response
    {
        return $this->render('aviary/show.html.twig', [
            'aviary' => $aviary,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_aviary_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Aviary $aviary, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AviaryType::class, $aviary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_aviary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('aviary/edit.html.twig', [
            'aviary' => $aviary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aviary_delete', methods: ['POST'])]
    public function delete(Request $request, Aviary $aviary, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aviary->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($aviary);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_aviary_index', [], Response::HTTP_SEE_OTHER);
    }
    
    # List all the birds inside an Aviary
    #[Route('/{id}/birds', name: 'app_aviary_birds', methods: ['GET'])]
    public function show_birds(Aviary $aviary): Response
    {
        $birds = $aviary->getBirds();
        
        return $this->render('aviary/show_birds.twig', [
            'aviary' => $aviary,
            'birds' => $birds]);
    }
    
    # Display each bird individually with a link to go back to the associated aviary
    /**
     * Show a bird in the context of an aviary
     *
     * @param Aviary $aviary              the aviary which diplays the bird 
     * @param Birds $birds   the bird to display 
     */
    #[Route('/{aviary_id}/birds/{birds_id}',
        methods: ['GET'],
        name: 'app_aviary_birds_show')]
        public function birdsShow(
            #[MapEntity(id: 'aviary_id')]
            Aviary $aviary,
            #[MapEntity(id: 'birds_id')]
            Birds $birds
            ): Response
            {
                if (! $aviary->getBirds()->contains($birds)){
                    throw $this->createNotFoundException("Couldn't find such a bird in this aviary!");
                }
                
                if (! $aviary->isPublished()) {
                    throw $this->createAccessDeniedException("You cannot acces the requested aviary");
                }
                return $this->render('aviary/birds_show.twig', [
                    'bird' => $birds,
                    'aviary' => $aviary
                ]);
        }
}
