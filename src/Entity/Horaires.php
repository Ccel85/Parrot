<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\HorairesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HorairesRepository::class)]
class Horaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique:true)]
    #[Assert\NotBlank()]
    private ?string $joursOuverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heuresDebutAM = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heuresFinAM = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heuresDebutPM = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heuresFinPM = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJoursOuverture(): ?string
    {
        return $this->joursOuverture;
    }

    public function setJoursOuverture(string $joursOuverture): static
    {
        $this->joursOuverture = $joursOuverture;

        return $this;
    }

    public function getHeuresDebutAM(): ?\DateTimeInterface
    {
        return $this->heuresDebutAM;
    }

    public function setHeuresDebutAM(\DateTimeInterface $heuresDebutAM): static
    {
        $this->heuresDebutAM = $heuresDebutAM;

        return $this;
    }

    public function getHeuresFinAM(): ?\DateTimeInterface
    {
        return $this->heuresFinAM;
    }

    public function setHeuresFinAM(\DateTimeInterface $heuresFinAM): static
    {
        $this->heuresFinAM = $heuresFinAM;

        return $this;
    }

    public function getHeuresDebutPM(): ?\DateTimeInterface
    {
        return $this->heuresDebutPM;
    }

    public function setHeuresDebutPM(\DateTimeInterface $heuresDebutPM): static
    {
        $this->heuresDebutPM = $heuresDebutPM;

        return $this;
    }

    public function getHeuresFinPM(): ?\DateTimeInterface
    {
        return $this->heuresFinPM;
    }

    public function setHeuresFinPM(\DateTimeInterface $heuresFinPM): static
    {
        $this->heuresFinPM = $heuresFinPM;

        return $this;
    }
}
