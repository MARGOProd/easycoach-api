<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FrequenceRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *  normalizationContext={"skip_null_values" = false},
 * )
 * @ApiFilter(SearchFilter::class, properties={"serieExerice"="exact"})
 * @ORM\Entity(repositoryClass=FrequenceRepository::class)
 */
class Frequence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"seance:get"})
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"seance:get"})
     */
    private $sets;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get"})
     */
    private $reps;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get"})
     */
    private $exerciceTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get"})
     */
    private $restTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get"})
     */
    private $breakTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get"})
     */
    private $startDelay;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get"})
     */
    private $limitTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSets(): ?int
    {
        return $this->sets;
    }

    public function setSets(int $sets): self
    {
        $this->sets = $sets;

        return $this;
    }

    public function getReps(): ?int
    {
        return $this->reps;
    }

    public function setReps(?int $reps): self
    {
        $this->reps = $reps;
        return $this;
    }

    public function getExerciceTime(): ?int
    {
        return $this->exerciceTime;
    }

    public function setExerciceTime(?int $exerciceTime): self
    {
        $this->exerciceTime = $exerciceTime;

        return $this;
    }

    public function getRestTime(): ?int
    {
        return $this->restTime;
    }

    public function setRestTime(?int $restTime): self
    {
        $this->restTime = $restTime;

        return $this;
    }

    public function getBreakTime(): ?int
    {
        return $this->breakTime;
    }

    public function setBreakTime(?int $breakTime): self
    {
        $this->breakTime = $breakTime;

        return $this;
    }

    public function getStartDelay(): ?int
    {
        return $this->startDelay;
    }

    public function setStartDelay(?int $startDelay): self
    {
        $this->startDelay = $startDelay;

        return $this;
    }

    public function getLimitTime(): ?int
    {
        return $this->limitTime;
    }

    public function setLimitTime(?int $limitTime): self
    {
        $this->limitTime = $limitTime;

        return $this;
    }
}
