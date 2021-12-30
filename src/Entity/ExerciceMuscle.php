<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExerciceMuscleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ExerciceMuscleRepository::class)
 */
class ExerciceMuscle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Exercice::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $exercice;

    /**
     * @ORM\ManyToOne(targetEntity=Muscle::class, inversedBy="exerciceMuscles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $muscle;

    /**
     * @ORM\Column(type="boolean")
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
