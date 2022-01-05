<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SerieExerciceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=SerieExerciceRepository::class)
 */
class SerieExercice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "serie:get","exerciceRealises:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="serieExercices")
     * @ORM\JoinColumn(nullable=true)
     */
    private $serie;

    /**
     * @ORM\ManyToOne(targetEntity=Exercice::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"seance:get", "serie:get", "exerciceRealises:get"})
     */
    private $exercice;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "serie:get", "exerciceRealises:get"})
     */
    private $repetition;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"seance:get", "serie:get", "exerciceRealises:get"})
     */
    private $poids;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get", "serie:get", "exerciceRealises:get"})
     */
    private $calorie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get", "serie:get", "exerciceRealises:get"})
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity=Materiel::class, inversedBy="serieExercices")
     */
    private $materiel;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): self
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getRepetition(): ?int
    {
        return $this->repetition;
    }

    public function setRepetition(int $repetition): self
    {
        $this->repetition = $repetition;

        return $this;
    }

    public function getPoids(): ?string
    {
        return $this->poids;
    }

    public function setPoids(?string $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getCalorie(): ?int
    {
        return $this->calorie;
    }

    public function setCalorie(?int $calorie): self
    {
        $this->calorie = $calorie;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getMateriel(): ?Materiel
    {
        return $this->materiel;
    }

    public function setMateriel(?Materiel $materiel): self
    {
        $this->materiel = $materiel;

        return $this;
    }

}
