<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentsRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks()]
#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "datetime_immutable")]
    private ?\DateTimeImmutable $isCreatedAt=null ;

    #[Assert\NotBlank()]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $comments = null;

    #[ORM\Column(nullable: true)]
    private ?int $rating = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->isCreatedAt = new \DateTimeImmutable();
    }
    
    public function getIsCreatedAt(): ?\DateTimeImmutable
    {
        return $this->isCreatedAt;
    }

    public function setIsCreatedAt(\DateTimeImmutable $isCreatedAt): self
    {
        $this->isCreatedAt = $isCreatedAt;

        return $this;
    }
    #[ORM\PrePersist]
public function setIsCreatedAtValue()
{
    if ($this->isCreatedAt === null) {
        $this->isCreatedAt = new \DateTimeImmutable();
    }
}


    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(string $comments): static
    {
        $this->comments = $comments;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

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
