<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
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
    #[Assert\NotBlank()]
    private ?Annonces $path_images = null;

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
}
