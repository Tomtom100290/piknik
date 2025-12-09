<?php

namespace App\Repository;

use App\Entity\Favoris;
use App\Entity\Lieu;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Favoris>
 */
class FavorisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favoris::class);
    }
    public function isLieuFavori(User $user, Lieu $lieu): bool
    {
        return $this->count(['fkUser' => $user, 'fk_lieu' => $lieu]) > 0;
    }

    public function findByUser($user): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.fkUser = :user')
            ->setParameter('user', $user)
            ->orderBy('f.dateCreat', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function findTopFavoris(): array
    {
        return $this->createQueryBuilder('f')
            ->select('l.id, l.nom, l.description, COUNT(f.id) AS favoris_count')
            ->join('f.fk_lieu', 'l')
            ->groupBy('l.id')
            ->orderBy('favoris_count', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }
}
