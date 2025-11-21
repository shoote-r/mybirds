<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Garden;
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
    
    #[Route('/', name: 'app_birds_index', methods: ['GET'])]
    public function index(BirdsRepository $birdsRepository): Response
    {
        // ADMIN → peut tout voir
        if ($this->isGranted('ROLE_ADMIN')) {
            $birds = $birdsRepository->findAll();
        }
        else {
            $member = $this->getUser();
            $birds = $birdsRepository->findMemberBirds($member);
        }
        
        return $this->render('birds/index.html.twig', [
            'birds' => $birds,
        ]);
    }
    
    
    #[Route('/birds/new/{id}', name: 'app_birds_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Garden $garden): Response
    {
        $bird = new Birds();
        $bird->setGarden($garden);
        
        $form = $this->createForm(BirdsType::class, $bird);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion du fichier image uploadé
            $imageFile = $form->get('imageFile')->getData();
            
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('birds_images_directory'),
                        $newFilename
                        );
                } catch (FileException $e) {
                    // Optionnel : journaliser ou gérer l'erreur
                }
                
                $bird->setImageFilename($newFilename);
            }
            
            $entityManager->persist($bird);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_garden_show', [
                'id' => $garden->getId(),
            ], Response::HTTP_SEE_OTHER);
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
            $imageFile = $form->get('imageFile')->getData();
            
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('birds_images_directory'),
                        $newFilename
                        );
                } catch (FileException $e) {
                    // Gérer l'erreur si besoin
                }
                
                $bird->setImageFilename($newFilename);
            }
            
            $entityManager->flush();
            
            return $this->redirectToRoute('app_garden_show', [
                'id' => $bird->getGarden()->getId(),
            ]);
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
            
            $imageFilename = $bird->getImageFilename();
            if ($imageFilename) {
                $imagePath = $this->getParameter('birds_images_directory') . '/' . $imageFilename;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            $entityManager->remove($bird);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_garden_show', [
            'id' => $bird->getGarden()->getId(),
        ]);
    }
    
}
