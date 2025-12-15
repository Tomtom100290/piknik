<?php

namespace App\Controller;

use App\Repository\FavorisRepository;
use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function indexHome(FavorisRepository $favorisRepository, LieuRepository $lieuRepository): Response
    {
        $user = $this->getUser(); // récupère l'utilisateur connecté
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        // $user est typé UserInterface, getId() fonctionne si User a la méthode getId()
        $favoris = $favorisRepository->findBy(['fkUser' => $user]);
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'lieus' => $lieuRepository->findAll(),
            'favoris' => $favoris,
        ]);
    }
}
