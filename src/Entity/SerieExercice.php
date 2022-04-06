<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SerieExerciceRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *  normalizationContext={"groups"={"serie_exercices:get"}, "skip_null_values" = false},
 *  attributes={"order"={"ordre": "ASC"}}
 * )
 * @ORM\Entity(repositoryClass=SerieExerciceRepository::class)
 * @ApiFilter(OrderFilter::class, properties={"ordre" : "DESC"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(SearchFilter::class, properties={"serie"="exact"})
 */
class SerieExercice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "exerciceRealises:get", "serie_exercices:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="serieExercices")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"serie_exercices:get"})
     */
    private $serie;

    /**
     * @ORM\ManyToOne(targetEntity=Exercice::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"seance:get","exerciceRealises:get", "serie_exercices:get"})
     */
    private $exercice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get", "exerciceRealises:get", "serie_exercices:get"})
     */
    private $repetition;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"seance:get","exerciceRealises:get", "serie_exercices:get"})
     */
    private $poids;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get","exerciceRealises:get", "serie_exercices:get"})
     */
    private $calorie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get", "exerciceRealises:get", "serie_exercices:get"})
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity=Materiel::class, inversedBy="serieExercices")
     */
    private $materiel;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get","exerciceRealises:get", "serie_exercices:get"})
     */
    private $ordre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get", "exerciceRealises:get", "serie_exercices:get"})
     */
    private $amplitude;

    /**
     * @ORM\ManyToOne(targetEntity=Tempo::class)
     * @Groups({"seance:get", "exerciceRealises:get", "serie_exercices:get"})
     */
    private $tempo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seance:get", "exerciceRealises:get", "serie_exercices:get"})
     */
    private $minute;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $done;


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

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(?int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getAmplitude(): ?int
    {
        return $this->amplitude;
    }

    public function setAmplitude(?int $amplitude): self
    {
        $this->amplitude = $amplitude;

        return $this;
    }

    public function getTempo(): ?Tempo
    {
        return $this->tempo;
    }

    public function setTempo(?Tempo $tempo): self
    {
        $this->tempo = $tempo;

        return $this;
    }

    public function getMinute(): ?int
    {
        return $this->minute;
    }

    public function setMinute(?int $minute): self
    {
        $this->minute = $minute;

        return $this;
    }

    public function getDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(?bool $done): self
    {
        $this->done = $done;

        return $this;
    }

}
