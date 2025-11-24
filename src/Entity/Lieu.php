<?php

namespace App\Entity;

use App\Enum\ValidationStatus;
use App\Enum\ValorisationEquipement;
use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LieuRepository::class)]
class Lieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $statut = null;

    #[ORM\Column]
    
    private ?\DateTimeImmutable $date_creat = null;

    /*Validation */
    #[ORM\Column(enumType: ValidationStatus::class)]
    private ValidationStatus $etat = ValidationStatus::EN_ATTENTE;

    /*Valorisation des équipement */
    #[ORM\Column(enumType: ValorisationEquipement::class)]
    private ?ValorisationEquipement $valo = null;

    #[ORM\ManyToOne(inversedBy: 'lieus')]
    private ?Categorie $categorie_fk = null;

    #[ORM\ManyToOne(inversedBy: 'lieus')]
    private ?Commune $Arrondissement = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'lieu_fk')]
    private Collection $images;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'fk_lieu')]
    private Collection $avis;

    /**
     * @var Collection<int, Favoris>
     */
    #[ORM\OneToMany(targetEntity: Favoris::class, mappedBy: 'fk_lieu')]
    private Collection $favoris;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
    /*ENUM pour le statut de validation */
    public function getEtat(): ValidationStatus
    {
        return $this->etat;
    }

    public function setEtat(ValidationStatus $etat): self
    {
        $this->etat = $etat;
        return $this;
    }

    /*ENUM pour la valorisation des équipements */
    public function getValoEquip(): ValorisationEquipement
    {
        return $this->valo;
    }

    public function setValoEquip(ValorisationEquipement $valo): self
    {
        $this->valo = $valo;
        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): static
    {
        $this->statut = $statut;

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

    public function getCategorieFk(): ?Categorie
    {
        return $this->categorie_fk;
    }

    public function setCategorieFk(?Categorie $categorie_fk): static
    {
        $this->categorie_fk = $categorie_fk;

        return $this;
    }

    public function getArrondissement(): ?Commune
    {
        return $this->Arrondissement;
    }

    public function setArrondissement(?Commune $Arrondissement): static
    {
        $this->Arrondissement = $Arrondissement;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setLieuFk($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getLieuFk() === $this) {
                $image->setLieuFk(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setFkLieu($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getFkLieu() === $this) {
                $avi->setFkLieu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favoris>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favoris $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
            $favori->setFkLieu($this);
        }

        return $this;
    }

    public function removeFavori(Favoris $favori): static
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getFkLieu() === $this) {
                $favori->setFkLieu(null);
            }
        }

        return $this;
    }
}
