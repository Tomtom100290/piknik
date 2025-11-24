<?php

namespace App\Entity;

use App\Repository\FavorisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavorisRepository::class)]
class Favoris
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_creat = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    private ?Lieu $fk_lieu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreat(): ?\DateTimeImmutable
    {
        return $this->date_creat;
    }

    public function setDateCreat(\DateTimeImmutable $date_creat): static
    {
        $this->date_creat = $date_creat;

        return $this;
    }

    public function getFkLieu(): ?Lieu
    {
        return $this->fk_lieu;
    }

    public function setFkLieu(?Lieu $fk_lieu): static
    {
        $this->fk_lieu = $fk_lieu;

        return $this;
    }
}
