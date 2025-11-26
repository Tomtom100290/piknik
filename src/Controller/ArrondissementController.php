<?php

namespace App\Controller;

use App\Entity\Arrondissement;
use App\Form\ArrondissementType;
use App\Repository\ArrondissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/arrondissement')]
final class ArrondissementController extends AbstractController
{
    #[Route(name: 'app_arrondissement_index', methods: ['GET'])]
    public function index(ArrondissementRepository $arrondissementRepository): Response
    {
        return $this->render('arrondissement/index.html.twig', [
            'arrondissements' => $arrondissementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_arrondissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $arrondissement = new Arrondissement();
        $form = $this->createForm(ArrondissementType::class, $arrondissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($arrondissement);
            $entityManager->flush();

            return $this->redirectToRoute('app_arrondissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('arrondissement/new.html.twig', [
            'arrondissement' => $arrondissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_arrondissement_show', methods: ['GET'])]
    public function show(Arrondissement $arrondissement): Response
    {
        return $this->render('arrondissement/show.html.twig', [
            'arrondissement' => $arrondissement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_arrondissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Arrondissement $arrondissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArrondissementType::class, $arrondissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_arrondissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('arrondissement/edit.html.twig', [
            'arrondissement' => $arrondissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_arrondissement_delete', methods: ['POST'])]
    public function delete(Request $request, Arrondissement $arrondissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$arrondissement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($arrondissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_arrondissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
