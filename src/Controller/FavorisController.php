<?php
namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\Lieu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FavorisController extends AbstractController
{
    #[Route('/favoris/toggle/{id}', name: 'favoris_toggle', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function toggle(
        Lieu $lieu,
        EntityManagerInterface $em
    ): JsonResponse {
        $user = $this->getUser();
        
        // Vérifier si le lieu est déjà en favori
        // CORRECTION ICI : utiliser 'fk_lieu' au lieu de 'fkLieu'
        $favoris = $em->getRepository(Favoris::class)->findOneBy([
            'fkUser' => $user,
            'fk_lieu' => $lieu  // ⚠️ Changement ici
        ]);

        if ($favoris) {
            // Retirer des favoris
            $em->remove($favoris);
            $em->flush();
            
            return new JsonResponse([
                'success' => true,
                'action' => 'removed',
                'message' => 'Lieu retiré des favoris'
            ]);
        } else {
            // Ajouter aux favoris
            $favoris = new Favoris();
            $favoris->setFkUser($user);
            $favoris->setFkLieu($lieu);
            $favoris->setDateCreat(new \DateTimeImmutable()); // ⚠️ N'oubliez pas d'initialiser la date
            
            $em->persist($favoris);
            $em->flush();
            
            return new JsonResponse([
                'success' => true,
                'action' => 'added',
                'message' => 'Lieu ajouté aux favoris'
            ]);
        }
    }

    #[Route('/mes-favoris', name: 'app_mes_favoris')]
    #[IsGranted('ROLE_USER')]
    public function mesFavoris(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        
        $favoris = $em->getRepository(Favoris::class)->findBy(
            ['fkUser' => $user],
            ['date_creat' => 'DESC']
        );

        return $this->render('favoris/index.html.twig', [
            'favoris' => $favoris,
        ]);
    }
}