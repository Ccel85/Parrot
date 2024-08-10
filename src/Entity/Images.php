<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImagesRepository;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private ?Annonces $path_images = null;

    #[ORM\Column(length: 255)]
    private $imagesfiles = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPathImages(): ?Annonces
    {
        return $this->path_images;
    }

    public function setPathImages(?Annonces $path_images): static
    {
        $this->path_images = $path_images;

        return $this;
    }

    public function getImagesfiles(): ?string
    {
        return $this->imagesfiles;
    }

    public function setImagesfiles(string $imagesfiles = null): void
    {
        $this->imagesfiles = $imagesfiles;
    }
}
