<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExerciceCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ExerciceCategorieRepository::class)
 */
class ExerciceCategorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=ExerciceCategorie::class, inversedBy="exerciceCategories")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceCategorie::class, mappedBy="parent")
     */
    private $exerciceCategories;

    /**
     * @ORM\OneToMany(targetEntity=Exercice::class, mappedBy="exerciceCategorie")
     */
    private $exercices;

    public function __construct()
    {
        $this->exerciceCategories = new ArrayCollection();
        $this->exercices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getExerciceCategories(): Collection
    {
        return $this->exerciceCategories;
    }

    public function addExerciceCategory(self $exerciceCategory): self
    {
        if (!$this->exerciceCategories->contains($exerciceCategory)) {
            $this->exerciceCategories[] = $exerciceCategory;
            $exerciceCategory->setParent($this);
        }

        return $this;
    }

    public function removeExerciceCategory(self $exerciceCategory): self
    {
        if ($this->exerciceCategories->removeElement($exerciceCategory)) {
            // set the owning side to null (unless already changed)
            if ($exerciceCategory->getParent() === $this) {
                $exerciceCategory->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Exercice[]
     */
    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercice $exercice): self
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices[] = $exercice;
            $exercice->setExerciceCategorie($this);
        }

        return $this;
    }

    public function removeExercice(Exercice $exercice): self
    {
        if ($this->exercices->removeElement($exercice)) {
            // set the owning side to null (unless already changed)
            if ($exercice->getExerciceCategorie() === $this) {
                $exercice->setExerciceCategorie(null);
            }
        }

        return $this;
    }
}
