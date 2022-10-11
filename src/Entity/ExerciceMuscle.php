<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExerciceMuscleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
/**
 * @ApiResource(
 *  normalizationContext={"groups"={"exerciceMuscle:get"}, "skip_null_values" = false},
 * 
 * )
 * @ORM\Entity(repositoryClass=ExerciceMuscleRepository::class) 
 * @ApiFilter(SearchFilter::class, properties={"exercice"="exact", "muscle"="exact", "isDirect"="exact", "muscle.groupeMusculaire"="exact"})
 * @UniqueEntity(
 *     fields={"exercice" , "muscle", "isDirect"},
 *     errorPath="ExerciceMuscle",
 *     message="This exerciceMuscle already exists."
 * )
 */
class ExerciceMuscle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"exercice:get","exerciceMuscle:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Exercice::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"exercice:get", "exerciceMuscle:get"})
     */
    private $exercice;

    /**
     * @ORM\ManyToOne(targetEntity=Muscle::class, inversedBy="exerciceMuscles")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"exercice:get", "exerciceMuscle:get"})
     */
    private $muscle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"exercice:get", "exerciceMuscle:get"})
     */
    private $isDirect;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): self
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getMuscle(): ?Muscle
    {
        return $this->muscle;
    }

    public function setMuscle(?Muscle $muscle): self
    {
        $this->muscle = $muscle;

        return $this;
    }

    public function getIsDirect(): ?bool
    {
        return $this->isDirect;
    }

    public function setIsDirect(bool $isDirect): self
    {
        $this->isDirect = $isDirect;

        return $this;
    }
}
