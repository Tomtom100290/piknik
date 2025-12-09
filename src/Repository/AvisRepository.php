<?php

namespace App\Repository;

use App\Entity\Avis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Avis>
 */
class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }
    /* Avis et commentaires */
    public function findbyAvis(): array
    {
        // Retourne les avis avec leur lieu et utilisateur pour affichage
        return $this->createQueryBuilder('a')
            ->leftJoin('a.fk_lieu', 'l')
            ->addSelect('l')
            ->leftJoin('a.fk_user', 'u')
            ->addSelect('u')
            ->orderBy('a.date_creat', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function getMoyennesNotesParLieux(array $lieuxIds): array
    {
        if (empty($lieuxIds)) {
            return [];
        }

        $results = $this->createQueryBuilder('a')
            ->select('IDENTITY(a.fk_lieu) as lieu_id, AVG(a.note) as moyenne')
            ->where('a.fk_lieu IN (:lieux)')
            ->andWhere('a.statut = :statut')  // Filtrer uniquement les avis validés
            ->setParameter('lieux', $lieuxIds)
            ->setParameter('statut', true)
            ->groupBy('a.fk_lieu')
            ->getQuery()
            ->getResult();

        $moyennes = [];
        foreach ($results as $result) {
            $moyennes[(int)$result['lieu_id']] = (float) $result['moyenne'];
        }

        return $moyennes;
    }
}
