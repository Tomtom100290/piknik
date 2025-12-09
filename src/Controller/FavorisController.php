<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\Lieu;
use App\Repository\FavorisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FavorisController extends AbstractController
{
    #[Route('/lieu/{id}/toggle-favoris', name: 'app_lieu_toggle_favoris', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function toggleFavoris(Lieu $lieu, EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();

        // Vérifier si le favori existe déjà
        $favorisExistant = $em->getRepository(Favoris::class)->findOneBy([
            'fk_lieu' => $lieu,
            'fkUser' => $user
        ]);

        if ($favorisExistant) {
            // Supprimer le favori
            $em->remove($favorisExistant);
            $em->flush();

            return $this->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Retiré des favoris'
            ]);
        }

        // Ajouter aux favoris
        $favoris = new Favoris();
        $favoris->setFkLieu($lieu);
        $favoris->setFkUser($user);

        $em->persist($favoris);
        $em->flush();

        return $this->json([
            'success' => true,
            'action' => 'added',
            'message' => 'Ajouté aux favoris'
        ]);
    }
    #[Route('/mes-favoris', name: 'mes_favoris')]
    public function index(FavorisRepository $favorisRepository): Response
    {
        $user = $this->getUser(); // récupère l'utilisateur connecté
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        // $user est typé UserInterface, getId() fonctionne si User a la méthode getId()
        $favoris = $favorisRepository->findBy(['fkUser' => $user]);

        return $this->render('favoris/mesfavoris.html.twig', [
            'favoris' => $favoris,
        ]);
    }
}
