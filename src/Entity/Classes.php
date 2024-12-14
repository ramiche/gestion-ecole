<?php

namespace App\Entity;

use App\Repository\ClassesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassesRepository::class)]
class Classes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomClasse = null;

    #[ORM\OneToMany(mappedBy: 'classeEleve', targetEntity: Eleves::class)]
    private Collection $eleves;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Professeurs $professeur = null;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClasse(): ?string
    {
        return $this->nomClasse;
    }

    public function setNomClasse(string $nomClasse): self
    {
        $this->nomClasse = $nomClasse;

        return $this;
    }

    /**
     * @return Collection<int, Eleves>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleves $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves->add($elefe);
            $elefe->setClasseEleve($this);
        }

        return $this;
    }

    public function removeElefe(Eleves $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getClasseEleve() === $this) {
                $elefe->setClasseEleve(null);
            }
        }

        return $this;
    }

    public function getProfesseur(): ?Professeurs
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeurs $professeur): self
    {
        $this->professeur = $professeur;

        return $this;
    }
    
}
