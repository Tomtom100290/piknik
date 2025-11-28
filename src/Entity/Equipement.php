<?php

namespace App\Entity;

use App\Enum\ValorisationEquipement;
use App\Repository\EquipementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementRepository::class)]
class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;
    /*Valorisation des équipement */
    #[ORM\Column(enumType: ValorisationEquipement::class)]
    private ValorisationEquipement $valo = ValorisationEquipement::INTERET_BON; 

    #[ORM\Column]
    private ?\DateTimeImmutable $date_creat = null;

    /**
     * @var Collection<int, Lieu>
     */
    #[ORM\ManyToMany(targetEntity: Lieu::class, mappedBy: 'fk_equipement')]
    private Collection $lieus;

    public function __construct()
    {
        // La date s’auto-génère dès la création de l’objet
        $this->date_creat = new \DateTimeImmutable();
        $this->lieus = new ArrayCollection();
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

    /*ENUM pour la valorisation des équipements */
    public function getValo(): ValorisationEquipement
    {
        return $this->valo;
    }

    public function setValo(ValorisationEquipement $valo): self
    {
        $this->valo = $valo;
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
            $lieu->addFkEquipement($this);
        }

        return $this;
    }

    public function removeLieu(Lieu $lieu): static
    {
        if ($this->lieus->removeElement($lieu)) {
            $lieu->removeFkEquipement($this);
        }

        return $this;
    }
}
