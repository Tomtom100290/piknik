<?php

namespace App\Entity;

use App\Repository\ArrondissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArrondissementRepository::class)]
class Arrondissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    private ?string $code_postal = null;

    #[ORM\Column(length: 50)]
    private ?string $localite = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'fk_arrondissement')]
    private Collection $users;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_creat = null;

    #[ORM\ManyToOne(inversedBy: 'arrondissements')]
    private ?Commune $fk_commune = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        // La date s’auto-génère dès la création de l’objet
        $this->date_creat = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getLocalite(): ?string
    {
        return $this->localite;
    }

    public function setLocalite(string $localite): static
    {
        $this->localite = $localite;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setFkArrondissement($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getFkArrondissement() === $this) {
                $user->setFkArrondissement(null);
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

    public function getFkCommune(): ?Commune
    {
        return $this->fk_commune;
    }

    public function setFkCommune(?Commune $fk_commune): static
    {
        $this->fk_commune = $fk_commune;

        return $this;
    }
}
