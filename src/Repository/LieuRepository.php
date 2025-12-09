<?php

namespace App\Repository;

use App\Entity\Lieu;
use App\Entity\User;
use App\Entity\Avis;
use App\Enum\ValidationStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lieu>
 */
class LieuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lieu::class);
    }
    /* Affiche leslieux valide */
    public function findValideLieux(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.etat = :etat')
            ->setParameter('etat', ValidationStatus::VALIDE)
            ->orderBy('l.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
    /* Affiche les favoris */
    public function findTopFavoris(): array
    {
        return $this->createQueryBuilder('f')
            ->select('l AS lieu, COUNT(f.id) AS nbFavoris')
            ->join('f.lieu', 'l')
            ->groupBy('l.id')
            ->orderBy('nbFavoris', 'DESC')
            ->getQuery()
            ->getResult();
    }
    /* Avis et commentaires */
    public function findbyAvis(): array
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.avis', 'r')
            ->addSelect('r')
            ->getQuery()
            ->getResult();
    }

    /*Liste les équipements */
    public function findByEquipements(?array $equipements): array
    {
        $qb = $this->createQueryBuilder('l')
            ->leftJoin('l.fk_equipement', 'e')
            ->addSelect('e');

        if (empty($equipements)) {
            return $qb
                ->getQuery()
                ->getResult();
        }

        return $qb
            ->andWhere('e.id IN (:equipements)')
            ->setParameter('equipements', $equipements)
            ->groupBy('l.id')
            ->getQuery()
            ->getResult();
    }
    /**
     * Récupérer les avis pour un lieu donné (délégué au repository Avis)
     */
    public function findByLieu(Lieu $lieu): array
    {
        return $this->_em->getRepository(Avis::class)->findBy([
            'fk_lieu' => $lieu,
        ], ['date_creat' => 'DESC']);
    }

    /**
     * Récupérer les avis d'un utilisateur (délégué au repository Avis)
     */
    public function findByUser(User $user): array
    {
        return $this->_em->getRepository(Avis::class)->findBy([
            'fk_user' => $user,
        ], ['id' => 'DESC']);
    }

    /**
     * Récupérer les avis validés (statut = true)
     */
    public function findValideEtActif(): array
    {
        return $this->_em->getRepository(Avis::class)->findBy([
            'statut' => true,
        ], ['note' => 'DESC']);
    }

    /**
     * Récupérer tous les avis triés par note (délégué au repository Avis)
     */
    public function findAllOrderByNote(): array
    {
        return $this->_em->getRepository(Avis::class)->findBy([], ['note' => 'DESC']);
    }
}
