<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Favoris;
use App\Entity\Image;
use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/lieu')]
final class LieuController extends AbstractController
{
    #[Route(name: 'app_lieu_index', methods: ['GET'])]
    public function index(LieuRepository $lieuRepository): Response
    {
        return $this->render('lieu/index.html.twig', [
            'lieus' => $lieuRepository->findAll(),
        ]);
    }
    /*Lieu valider*/
    #[Route('/lieuvalider', name: 'app_lieu_valide', methods: ['GET'])]
    public function lieuValid(LieuRepository $lieuRepository): Response
    {
        return $this->render('lieu/lieuvalide.html.twig', [
            'lieus' => $lieuRepository->findValideLieux(),
        ]);
    }

    #[Route('/new', name: 'app_lieu_new', methods: ['GET', 'POST'])]
   public function new(Request $request, EntityManagerInterface $em): Response
{
    $lieu = new Lieu();
    $form = $this->createForm(LieuType::class, $lieu);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        /** @var UploadedFile[] $files */
        $files = $form->get('imagesFiles')->getData();

        foreach ($files as $file) {
            $image = new Image();
            $image->setImageFile($file);   // ⚡ Vich va gérer l’upload
            $image->setLieuFk($lieu);      // on relie l’image au lieu
            $lieu->addImage($image);       // relation côté Lieu
        }

        $em->persist($lieu);
        $em->flush();

        return $this->redirectToRoute('app_lieu_index');
    }

    return $this->render('lieu/new.html.twig', [
        'form' => $form->createView(),
        'lieu' => $lieu,
    ]);
}

    #[Route('/{id}', name: 'app_lieu_show', methods: ['GET'])]
    public function show(Lieu $lieu,
    EntityManagerInterface $em
): Response {
    $isFavori = false;
    
    if ($this->getUser()) {
        $isFavori = $em->getRepository(Favoris::class)->isLieuFavori(
            $this->getUser(),
            $lieu
        );
    }
    
    return $this->render('lieu/show.html.twig', [
        'lieu' => $lieu,
        'is_favori' => $isFavori,
    ]);
    }

    #[Route('/{id}/edit', name: 'app_lieu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lieu $lieu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lieu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lieu/edit.html.twig', [
            'lieu' => $lieu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lieu_delete', methods: ['POST'])]
    public function delete(Request $request, Lieu $lieu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lieu->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($lieu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lieu_index', [], Response::HTTP_SEE_OTHER);
    }
}
