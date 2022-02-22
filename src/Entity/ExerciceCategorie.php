<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ExerciceCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"exerciceCategories:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=ExerciceCategorieRepository::class)
 * @ApiFilter(ExistsFilter::class, properties={"parent"})
 */
class ExerciceCategorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"exerciceCategories:get", "exercice:get", "exercices:get", "exercice:post"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"exerciceCategories:get", "exercice:get", "exercices:get", "exercice:post"})
     * 
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=ExerciceCategorie::class, inversedBy="exerciceCategories")
     * @Groups({"exerciceCategories:get"})
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceCategorie::class, mappedBy="parent")
     * @ApiSubresource
     */
    private $exerciceCategories;

    /**
     * @ORM\OneToMany(targetEntity=Exercice::class, mappedBy="exerciceCategorie")
     * @ApiSubresource
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
    
    /**
     * @Groups({"exerciceCategories:get","exercice:get", "exercices:get", "exercice:post"})
     */
    public function getNbSubCategorie()
    {
        return count($this->getExerciceCategories());
    }

    /**
     * @Groups({"exerciceCategories:get","exercice:get", "exercices:get", "exercice:post"})
     */
    public function getNbExercice()
    {
        return count($this->getExercices());
    }
}
