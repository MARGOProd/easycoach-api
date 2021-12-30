<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=MaterielRepository::class)
 */
class Materiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "serie:get", "exercice:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"seance:get", "serie:get", "exercice:get"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceMateriel::class, mappedBy="materiel")
     */
    private $exerciceMateriels;

    /**
     * @ORM\OneToMany(targetEntity=SerieExercice::class, mappedBy="materiel")
     */
    private $serieExercices;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceRealise::class, mappedBy="materiel")
     */
    private $exerciceRealises;

    public function __construct()
    {
        $this->exerciceMateriels = new ArrayCollection();
        $this->serieExercices = new ArrayCollection();
        $this->exerciceRealises = new ArrayCollection();
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

    /**
     * @return Collection|ExerciceMateriel[]
     */
    public function getExerciceMateriels(): Collection
    {
        return $this->exerciceMateriels;
    }

    public function addExerciceMateriel(ExerciceMateriel $exerciceMateriel): self
    {
        if (!$this->exerciceMateriels->contains($exerciceMateriel)) {
            $this->exerciceMateriels[] = $exerciceMateriel;
            $exerciceMateriel->setMateriel($this);
        }

        return $this;
    }

    public function removeExerciceMateriel(ExerciceMateriel $exerciceMateriel): self
    {
        if ($this->exerciceMateriels->removeElement($exerciceMateriel)) {
            // set the owning side to null (unless already changed)
            if ($exerciceMateriel->getMateriel() === $this) {
                $exerciceMateriel->setMateriel(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|SerieExercice[]
     */
    public function getSerieExercices(): Collection
    {
        return $this->serieExercices;
    }

    public function addSerieExercice(SerieExercice $serieExercice): self
    {
        if (!$this->serieExercices->contains($serieExercice)) {
            $this->serieExercices[] = $serieExercice;
            $serieExercice->setMateriel($this);
        }

        return $this;
    }

    public function removeSerieExercice(SerieExercice $serieExercice): self
    {
        if ($this->serieExercices->removeElement($serieExercice)) {
            // set the owning side to null (unless already changed)
            if ($serieExercice->getMateriel() === $this) {
                $serieExercice->setMateriel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExerciceRealise[]
     */
    public function getExerciceRealises(): Collection
    {
        return $this->exerciceRealises;
    }

    public function addExerciceRealise(ExerciceRealise $exerciceRealise): self
    {
        if (!$this->exerciceRealises->contains($exerciceRealise)) {
            $this->exerciceRealises[] = $exerciceRealise;
            $exerciceRealise->setMateriel($this);
        }

        return $this;
    }

    public function removeExerciceRealise(ExerciceRealise $exerciceRealise): self
    {
        if ($this->exerciceRealises->removeElement($exerciceRealise)) {
            // set the owning side to null (unless already changed)
            if ($exerciceRealise->getMateriel() === $this) {
                $exerciceRealise->setMateriel(null);
            }
        }

        return $this;
    }
}
