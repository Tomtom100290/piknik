<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 25)]
    private ?string $pseudo = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_creat = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Arrondissement $fk_arrondissement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
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

   

    public function getFkArrondissement(): ?Arrondissement
    {
        return $this->fk_arrondissement;
    }

    public function setFkArrondissement(?Arrondissement $fk_arrondissement): static
    {
        $this->fk_arrondissement = $fk_arrondissement;

        return $this;
    }
}
