<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Annonces $path_images = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $filename = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPathImages(): ?Annonces
    {
        return $this->path_images;
    }

    public function setPathImages(?Annonces $path_images): self
    {
        $this->path_images = $path_images;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }
}
