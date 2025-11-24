<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $attr_alt = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Lieu $lieu_fk = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getAttrAlt(): ?string
    {
        return $this->attr_alt;
    }

    public function setAttrAlt(?string $attr_alt): static
    {
        $this->attr_alt = $attr_alt;

        return $this;
    }

    public function getLieuFk(): ?Lieu
    {
        return $this->lieu_fk;
    }

    public function setLieuFk(?Lieu $lieu_fk): static
    {
        $this->lieu_fk = $lieu_fk;

        return $this;
    }
}
