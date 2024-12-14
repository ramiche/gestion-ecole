<?php

namespace App\Entity;

use App\Repository\ElevesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ElevesRepository::class)]
class Eleves
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomEleve = null;

    #[ORM\Column(length: 255)]
    private ?string $prenomEleve = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classes $classeEleve = null;
    #[ORM\Column(type: 'float')]
 
private ?float $moyenne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEleve(): ?string
    {
        return $this->nomEleve;
    }

    public function setNomEleve(string $nomEleve): self
    {
        $this->nomEleve = $nomEleve;

        return $this;
    }

    public function getPrenomEleve(): ?string
    {
        return $this->prenomEleve;
    }

    public function setPrenomEleve(string $prenomEleve): self
    {
        $this->prenomEleve = $prenomEleve;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getClasseEleve(): ?Classes
    {
        return $this->classeEleve;
    }

    public function setClasseEleve(?Classes $classeEleve): self
    {
        $this->classeEleve = $classeEleve;

        return $this;
    }
    public function getMoyenne(): ?float
{
    return $this->moyenne;
}

public function setMoyenne(float $moyenne): self
{
    $this->moyenne = $moyenne;

    return $this;
}

}
