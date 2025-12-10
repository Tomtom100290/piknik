<?php

namespace App\tests\Repository;

use App\Entity\Favoris;
use App\Entity\Lieu;
use App\Repository\FavorisRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FavorisRepositoryTest  extends KernelTestCase
{
    private $entityManager;
    private FavorisRepository $favorisRepository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = static::getContainer()->get('doctrine.orm.entity_manager');
        $this->favorisRepository = $this->entityManager->getRepository(Favoris::class);
    }

    public function testFindTopFavoris(): void
    {
        // --- Arrange ---
        // Création de 2 lieux
        $lieu1 = (new Lieu())->setNom("Parc A");
        $lieu2 = (new Lieu())->setNom("Parc B");

        $this->entityManager->persist($lieu1);
        $this->entityManager->persist($lieu2);

        // Ajouter 3 favoris pour lieu1
        for ($i = 0; $i < 3; $i++) {
            $f = (new Favoris())->setFkLieu($lieu1);
            $this->entityManager->persist($f);
        }

        // Ajouter 1 favoris pour lieu2
        $f2 = (new Favoris())->setFkLieu($lieu2);
        $this->entityManager->persist($f2);

        $this->entityManager->flush();

        // --- Act ---
        $result = $this->favorisRepository->findTopFavoris();

        // --- Assert ---
        $this->assertCount(2, $result);
        // Le 1er doit être $lieu1
        $this->assertEquals("Parc A", $result[0]['lieu']->getNom());
        $this->assertEquals(3, $result[0]['nbFavoris']);
        // Le 2nd doit être $lieu2
        $this->assertEquals("Parc B", $result[1]['lieu']->getNom());
        $this->assertEquals(1, $result[1]['nbFavoris']);
    }
}
