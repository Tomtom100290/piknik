<?php

namespace App\Tests\Repository;

use App\Entity\Favoris;
use App\Entity\Lieu;
use App\Entity\User;
use App\Repository\FavorisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FavorisRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private FavorisRepository $favorisRepository;

    protected function setUp(): void
    {
        $this->kernel = self::bootKernel(['environment' => 'test']);
        $container = $this->kernel->getContainer();
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->favorisRepository = $this->entityManager->getRepository(Favoris::class);

        // Créer le schéma de la base de données
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $tool->dropSchema($metadata);
        $tool->createSchema($metadata);
    }

    public function testFindTopFavoris(): void
    {
        // --- Arrange ---
        // Créer un utilisateur
        $user = (new User())
            ->setEmail('test@example.com')
            ->setPassword('hashed_password')
            ->setPrenom('Test')
            ->setPseudo('testuser');
        $this->entityManager->persist($user);

        // Création de 2 lieux
        $lieu1 = (new Lieu())
            ->setNom("Parc A")
            ->setDescription("Description Parc A");
        $lieu2 = (new Lieu())
            ->setNom("Parc B")
            ->setDescription("Description Parc B");

        $this->entityManager->persist($lieu1);
        $this->entityManager->persist($lieu2);
        $this->entityManager->flush();

        // Ajouter 3 favoris pour lieu1
        for ($i = 0; $i < 3; $i++) {
            $f = (new Favoris())
                ->setFkLieu($lieu1)
                ->setFkUser($user);
            $this->entityManager->persist($f);
        }

        // Ajouter 1 favoris pour lieu2
        $f2 = (new Favoris())
            ->setFkLieu($lieu2)
            ->setFkUser($user);
        $this->entityManager->persist($f2);

        $this->entityManager->flush();

        // --- Act ---
        $result = $this->favorisRepository->findTopFavoris();

        // --- Assert ---
        $this->assertIsArray($result);
        $this->assertGreaterThan(0, count($result));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
    }
}
