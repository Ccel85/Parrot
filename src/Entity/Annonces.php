<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnnoncesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: AnnoncesRepository::class)]
class Annonces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $constructeur = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $modele = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $carburant = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?int $km = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?int $année = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $couleur = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $boite = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?int $puissance_fiscal = null;

    #[ORM\Column]
    private ?int $puissance = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?int $nbre_porte = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $equipement_interieur = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $equipement_exterieur = null;

    /**
     * @var Collection<int, Images>
     */
    #[ORM\OneToMany(targetEntity: Images::class, mappedBy: 'path_images')]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConstructeur(): ?string
    {
        return $this->constructeur;
    }

    public function setConstructeur(string $constructeur): static
    {
        $this->constructeur = $constructeur;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(string $carburant): static
    {
        $this->carburant = $carburant;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): static
    {
        $this->km = $km;

        return $this;
    }

    public function getAnnée(): ?int
    {
        return $this->année;
    }

    public function setAnnée(int $année): static
    {
        $this->année = $année;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getBoite(): ?string
    {
        return $this->boite;
    }

    public function setBoite(string $boite): static
    {
        $this->boite = $boite;

        return $this;
    }

    public function getPuissanceFiscal(): ?int
    {
        return $this->puissance_fiscal;
    }

    public function setPuissanceFiscal(int $puissance_fiscal): static
    {
        $this->puissance_fiscal = $puissance_fiscal;

        return $this;
    }

    public function getPuissance(): ?int
    {
        return $this->puissance;
    }

    public function setPuissance(int $puissance): static
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getNbrePorte(): ?int
    {
        return $this->nbre_porte;
    }

    public function setNbrePorte(int $nbre_porte): static
    {
        $this->nbre_porte = $nbre_porte;

        return $this;
    }

    public function getEquipementInterieur(): ?string
    {
        return $this->equipement_interieur;
    }

    public function setEquipementInterieur(string $equipement_interieur): static
    {
        $this->equipement_interieur = $equipement_interieur;

        return $this;
    }

    public function getEquipementExterieur(): ?string
    {
        return $this->equipement_exterieur;
    }

    public function setEquipementExterieur(string $equipement_exterieur): static
    {
        $this->equipement_exterieur = $equipement_exterieur;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setPathImages($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPathImages() === $this) {
                $image->setPathImages(null);
            }
        }

        return $this;
    }
}
