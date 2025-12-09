<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Equipement;
use App\Entity\Favoris;
use App\Entity\Image;
use App\Entity\Lieu;
use App\Form\EquipementFilterType;
use App\Form\LieuType;
use App\Repository\AvisRepository;
use App\Repository\FavorisRepository;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Psr\Log\LoggerInterface;

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

    #[Route('/{id}', name: 'app_lieu_show', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function show(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        LieuRepository $lieuRepository,
        AvisRepository $avisRepository
    ): Response {
        /* Récupère les infos du lieu */
        $lieu = $lieuRepository->find($id);
        if (!$lieu) {
            throw $this->createNotFoundException('Lieu not found');
        }

        $isFavori = false;

        if ($this->getUser()) {
            $isFavori = $em->getRepository(Favoris::class)->isLieuFavori(
                $this->getUser(),
                $lieu
            );
        }

        /* Récupère les avis du lieu */
        // la propriété dans l'entité Avis est `fk_lieu`, utiliser findBy avec le bon champ
        $avis = $avisRepository->findBy([
            'fk_lieu' => $lieu,
        ], ['date_creat' => 'DESC']);

        return $this->render('lieu/show.html.twig', [
            'lieu' => $lieu,
            'is_favoris' => $isFavori,
            'avis' => $avis,
        ]);
    }

    #[Route('/{id}/toggle-favoris', name: 'app_lieu_toggle_favoris', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function toggleFavoris(Request $request, int $id, EntityManagerInterface $em, LoggerInterface $logger, LieuRepository $lieuRepository): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            $logger->warning('toggleFavoris: no user', ['lieu' => $id]);
            return new JsonResponse(['success' => false, 'message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $lieu = $lieuRepository->find($id);
        if (!$lieu) {
            $logger->warning('toggleFavoris: lieu not found', ['id' => $id]);
            return new JsonResponse(['success' => false, 'message' => 'Lieu not found'], Response::HTTP_NOT_FOUND);
        }

        $userIdentifier = is_object($user) && method_exists($user, 'getUserIdentifier') ? $user->getUserIdentifier() : null;
        $logger->info('toggleFavoris called', ['user' => $userIdentifier, 'lieu' => $id]);

        $repo = $em->getRepository(\App\Entity\Favoris::class);

        $existing = $repo->findOneBy([
            'fkUser' => $user,
            'fk_lieu' => $lieu,
        ]);

        if ($existing) {
            $logger->info('toggleFavoris: removing existing favoris', ['favoris_id' => $existing->getId()]);
            $em->remove($existing);
            $em->flush();

            return new JsonResponse(['success' => true, 'action' => 'removed']);
        }

        $favori = new \App\Entity\Favoris();
        $favori->setFkUser($user);
        $favori->setFkLieu($lieu);

        try {
            $em->persist($favori);
            $em->flush();
        } catch (\Throwable $e) {
            $logger->error('toggleFavoris: DB error', ['exception' => $e->getMessage()]);
            return new JsonResponse(['success' => false, 'message' => 'DB error: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $logger->info('toggleFavoris: added favoris', ['favoris_id' => $favori->getId()]);

        return new JsonResponse(['success' => true, 'action' => 'added', 'favoris_id' => $favori->getId()]);
    }

    #[Route('/{id}/edit', name: 'app_lieu_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, int $id, EntityManagerInterface $entityManager, LieuRepository $lieuRepository): Response
    {
        $lieu = $lieuRepository->find($id);
        if (!$lieu) {
            throw $this->createNotFoundException('Lieu not found');
        }

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

    #[Route('/{id}', name: 'app_lieu_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager, LieuRepository $lieuRepository): Response
    {
        $lieu = $lieuRepository->find($id);
        if (!$lieu) {
            throw $this->createNotFoundException('Lieu not found');
        }

        if ($this->isCsrfTokenValid('delete' . $lieu->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($lieu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lieu_index', [], Response::HTTP_SEE_OTHER);
    }
    // Les lieux les plus appréciés
    #[Route('/top-lieux', name: 'top_lieux')]
    public function topLieux(FavorisRepository $favorisRepository): Response
    {
        $topLieux = $favorisRepository->findTopFavoris();

        return $this->render('lieu/toplieux.html.twig', [
            'topLieux' => $topLieux,
        ]);
    }
    #[Route('/filtre-lieux', name: 'filtre_lieux')]
    public function filtreLieux(
        Request $request,
        LieuRepository $lieuRepository
    ): Response {
        // On crée le formulaire
        $form = $this->createForm(EquipementFilterType::class);
        $form->handleRequest($request);

        $equipements = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les équipements sélectionnés (ArrayCollection)
            $equipementsCollection = $form->get('equipements')->getData();

            // Convertir en tableau puis extraire les ID
            $equipements = array_map(
                fn($eq) => $eq->getId(),
                $equipementsCollection->toArray()
            );
        }

        // Appel du repository
        $lieux = $lieuRepository->findByEquipements($equipements);

        return $this->render('lieu/filtre_lieux.html.twig', [
            'form' => $form->createView(),
            'lieux' => $lieux,
        ]);
    }
}
