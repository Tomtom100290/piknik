<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommuneRepository::class)]
class Commune
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;
    

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $Code_postal_commune = null;

    /**
     * @var Collection<int, Lieu>
     */
    #[ORM\OneToMany(targetEntity: Lieu::class, mappedBy: 'Arrondissement')]
    private Collection $lieus;

    /**
     * @var Collection<int, Arrondissement>
     */
    #[ORM\OneToMany(targetEntity: Arrondissement::class, mappedBy: 'fk_commune')]
    private Collection $arrondissements;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_creat = null;

    public function __construct()
    {
        $this->lieus = new ArrayCollection();
        $this->arrondissements = new ArrayCollection();
        // La date s’auto-génère dès la création de l’objet
        $this->date_creat = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
     public function __toString(): string
    {
        return $this->nom ?? '';
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

    public function getCodePostalCommune(): ?string
    {
        return $this->Code_postal_commune;
    }

    public function setCodePostalCommune(?string $Code_postal_commune): static
    {
        $this->Code_postal_commune = $Code_postal_commune;

        return $this;
    }

    /**
     * @return Collection<int, Lieu>
     */
    public function getLieus(): Collection
    {
        return $this->lieus;
    }

    public function addLieu(Lieu $lieu): static
    {
        if (!$this->lieus->contains($lieu)) {
            $this->lieus->add($lieu);
            $lieu->setArrondissement($this);
        }

        return $this;
    }

    public function removeLieu(Lieu $lieu): static
    {
        if ($this->lieus->removeElement($lieu)) {
            // set the owning side to null (unless already changed)
            if ($lieu->getArrondissement() === $this) {
                $lieu->setArrondissement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Arrondissement>
     */
    public function getArrondissements(): Collection
    {
        return $this->arrondissements;
    }

    public function addArrondissement(Arrondissement $arrondissement): static
    {
        if (!$this->arrondissements->contains($arrondissement)) {
            $this->arrondissements->add($arrondissement);
            $arrondissement->setFkCommune($this);
        }

        return $this;
    }

    public function removeArrondissement(Arrondissement $arrondissement): static
    {
        if ($this->arrondissements->removeElement($arrondissement)) {
            // set the owning side to null (unless already changed)
            if ($arrondissement->getFkCommune() === $this) {
                $arrondissement->setFkCommune(null);
            }
        }

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
}
