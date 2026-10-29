<?php

namespace App\Controller;

use App\Entity\Population;
use App\Form\PopulationType;
use App\Repository\PopulationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/population')]
final class PopulationController extends AbstractController
{
    #[Route(name: 'app_population_index', methods: ['GET'])]
    public function index(PopulationRepository $populationRepository): Response
    {
        return $this->render('population/index.html.twig', [
            'populations' => $populationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_population_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $population = new Population();
        $form = $this->createForm(PopulationType::class, $population);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($population);
            $entityManager->flush();

            return $this->redirectToRoute('app_population_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('population/new.html.twig', [
            'population' => $population,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_population_show', methods: ['GET'])]
    public function show(Population $population): Response
    {
        return $this->render('population/show.html.twig', [
            'population' => $population,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_population_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Population $population, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PopulationType::class, $population);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_population_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('population/edit.html.twig', [
            'population' => $population,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_population_delete', methods: ['POST'])]
    public function delete(Request $request, Population $population, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$population->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($population);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_population_index', [], Response::HTTP_SEE_OTHER);
    }
}
