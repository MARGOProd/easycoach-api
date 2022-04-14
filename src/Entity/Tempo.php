<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TempoRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TempoRepository::class)
 */
class Tempo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "exerciceRealises:get", "serie_exercices:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get", "exerciceRealises:get", "serie_exercices:get"})
     */
    private $descente;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get", "exerciceRealises:get", "serie_exercices:get"})
     */
    private $static;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get", "exerciceRealises:get", "serie_exercices:get"})
     */
    private $montee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescente(): ?int
    {
        return $this->descente;
    }

    public function setDescente(?int $descente): self
    {
        $this->descente = $descente;

        return $this;
    }

    public function getStatic(): ?int
    {
        return $this->static;
    }

    public function setStatic(?int $static): self
    {
        $this->static = $static;

        return $this;
    }

    public function getMontee(): ?int
    {
        return $this->montee;
    }

    public function setMontee(?int $montee): self
    {
        $this->montee = $montee;

        return $this;
    }
}
