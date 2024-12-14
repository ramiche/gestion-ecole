<?php

namespace App\Controller;

use App\Entity\Professeurs;
use App\Form\ProfesseursType;
use App\Repository\ProfesseursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/professeurs')]
final class ProfesseursController extends AbstractController
{
    #[Route(name: 'app_professeurs_index', methods: ['GET'])]
    public function index(ProfesseursRepository $professeursRepository): Response
    {
        return $this->render('professeurs/index.html.twig', [
            'professeurs' => $professeursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_professeurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $professeur = new Professeurs();
        $form = $this->createForm(ProfesseursType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($professeur);
            $entityManager->flush();

            return $this->redirectToRoute('app_professeurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professeurs/new.html.twig', [
            'professeur' => $professeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professeurs_show', methods: ['GET'])]
    public function show(Professeurs $professeur): Response
    {
        return $this->render('professeurs/show.html.twig', [
            'professeur' => $professeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_professeurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Professeurs $professeur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfesseursType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_professeurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professeurs/edit.html.twig', [
            'professeur' => $professeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professeurs_delete', methods: ['POST'])]
    public function delete(Request $request, Professeurs $professeur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professeur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($professeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_professeurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
