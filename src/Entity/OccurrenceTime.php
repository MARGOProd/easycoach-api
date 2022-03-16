<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OccurrenceTimeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=OccurrenceTimeRepository::class)
 */
class OccurrenceTime
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $occurrence;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="occurrenceTimes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serie;

    /**
     * @ORM\Column(type="integer")
     */
    private $time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOccurrence(): ?int
    {
        return $this->occurrence;
    }

    public function setOccurrence(int $occurrence): self
    {
        $this->occurrence = $occurrence;

        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }
}
