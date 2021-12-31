<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExerciceRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"exercice:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=ExerciceRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"libelle"="partial"})
 * @ApiFilter(OrderFilter::class, properties={"id", "libelle"}, arguments={"orderParameterName"="order"})
 */
class Exercice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "exerciceRealises:get", "serie:get", "exercice:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"seance:get", "exerciceRealises:get", "serie:get", "exercice:get"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceMuscle::class, mappedBy="exercice")
     */
    private $exerciceMuscles;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceMateriel::class, mappedBy="exercice")
     */
    private $exerciceMateriels;

    public function __construct()
    {
        $this->exerciceMateriels = new ArrayCollection();
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
     * @return Collection|ExerciceMuscle[]
     */
    public function getExerciceMuscles(): Collection
    {
        return $this->exerciceMuscles;
    }

    public function addExerciceMuscle(ExerciceMuscle $exerciceMuscle): self
    {
        if (!$this->exerciceMuscles->contains($exerciceMuscle)) {
            $this->exerciceMuscles[] = $exerciceMuscle;
            $exerciceMuscle->setExercice($this);
        }

        return $this;
    }

    public function removeExerciceMuscle(ExerciceMuscle $exerciceMuscle): self
    {
        if ($this->exerciceMuscles->removeElement($exerciceMuscle)) {
            // set the owning side to null (unless already changed)
            if ($exerciceMuscle->getExercice() === $this) {
                $exerciceMuscle->setExercice(null);
            }
        }

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
            $exerciceMateriel->setExercice($this);
        }

        return $this;
    }

    public function removeExerciceMateriel(ExerciceMateriel $exerciceMateriel): self
    {
        if ($this->exerciceMateriels->removeElement($exerciceMateriel)) {
            // set the owning side to null (unless already changed)
            if ($exerciceMateriel->getExercice() === $this) {
                $exerciceMateriel->setExercice(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"seance:get", "serie:get", "exerciceRealises:get", "exercice:get"})
     */
    public function getMateriels()
    {
        $materiels = [];
        foreach($this->exerciceMateriels as $materiel)
        {
            $materiels = $materiel->getMateriel();
        }
        return $materiels;
    }

    /**
     * @Groups({"seance:get", "serie:get", "exerciceRealises:get", "exercice:get"})
     */
    public function getMuscles()
    {
        $muscles = array();
        foreach($this->exerciceMuscles as $muscle)
        {
            // !in_array($muscle->getMuscle(),$muscles,true );
            $muscles[] = $muscle->getMuscle();
        }
        return $muscles;
    }
}
