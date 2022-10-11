<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MuscleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"muscle:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=MuscleRepository::class)
 */
class Muscle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "serie:get", "exercice:get", "muscle:get", "exercices:get", "client:get", "groupeMusculaires:get", "commentaireMuscles:get", "exerciceMuscle:get" })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"seance:get", "serie:get", "exercice:get", "muscle:get", "exercices:get", "client:get", "groupeMusculaires:get", "commentaireMuscles:get", "exerciceMuscle:get"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"seance:get", "serie:get", "exercice:get", "muscle:get", "exercices:get", "client:get", "exerciceMuscle:get"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=GroupeMusculaire::class, inversedBy="muscles")
     * @Groups({"seance:get", "serie:get", "exercice:get", "muscle:get", "exercices:get", "client:get", "commentaireMuscles:get", "exerciceMuscle:get"})
     */
    private $groupeMusculaire;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceMuscle::class, mappedBy="muscle")
     */
    private $exerciceMuscles;

    /**
     * @ORM\OneToMany(targetEntity=CommentaireMuscle::class, mappedBy="muscle")
     */
    private $commentaireMuscles;

     /**
     * @Groups({"seance:get", "serie:get", "exercice:get", "muscle:get", "exercices:get", "client:get", "groupeMusculaires:get", "commentaireMuscles:get" })
     */
    public $isSelected;


    public function __construct()
    {
        $this->exerciceMuscles = new ArrayCollection();
        $this->commentaireMuscles = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getGroupeMusculaire(): ?GroupeMusculaire
    {
        return $this->groupeMusculaire;
    }

    public function setGroupeMusculaire(?GroupeMusculaire $groupeMusculaire): self
    {
        $this->groupeMusculaire = $groupeMusculaire;

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
            $exerciceMuscle->setMuscle($this);
        }

        return $this;
    }

    public function removeExerciceMuscle(ExerciceMuscle $exerciceMuscle): self
    {
        if ($this->exerciceMuscles->removeElement($exerciceMuscle)) {
            // set the owning side to null (unless already changed)
            if ($exerciceMuscle->getMuscle() === $this) {
                $exerciceMuscle->setMuscle(null);
            }
        }

        return $this;
    }


    public function getIsSelected()
    {
        return $this->isSelected;
    }

    public function setIsSelected(bool $isSelected): self
    {
        $this->isSelected = $isSelected;
        return $this;
    }

    /**
     * @return Collection|CommentaireMuscle[]
     */
    public function getCommentaireMuscles(): Collection
    {
        return $this->commentaireMuscles;
    }

    public function addCommentaireMuscle(CommentaireMuscle $commentaireMuscle): self
    {
        if (!$this->commentaireMuscles->contains($commentaireMuscle)) {
            $this->commentaireMuscles[] = $commentaireMuscle;
            $commentaireMuscle->setMuscle($this);
        }

        return $this;
    }

    public function removeCommentaireMuscle(CommentaireMuscle $commentaireMuscle): self
    {
        if ($this->commentaireMuscles->removeElement($commentaireMuscle)) {
            // set the owning side to null (unless already changed)
            if ($commentaireMuscle->getMuscle() === $this) {
                $commentaireMuscle->setMuscle(null);
            }
        }

        return $this;
    }
}
