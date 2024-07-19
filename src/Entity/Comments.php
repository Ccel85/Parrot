<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $isCreatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $Comments = null;

    #[ORM\Column(nullable: true)]
    private ?int $Rating = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsCreatedAt(): ?\DateTimeImmutable
    {
        return $this->isCreatedAt;
    }

    public function setIsCreatedAt(\DateTimeImmutable $isCreatedAt): static
    {
        $this->isCreatedAt = $isCreatedAt;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->Comments;
    }

    public function setComments(string $Comments): static
    {
        $this->Comments = $Comments;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->Rating;
    }

    public function setRating(?int $Rating): static
    {
        $this->Rating = $Rating;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
