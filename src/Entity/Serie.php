<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SerieRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Filter\Validator\Length;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"series:get"}, "skip_null_values" = false},
 *  itemOperations={
 *       "get"={"normalization_context"={"groups"="serie:get"}},
 *       "delete",
 *       "put"
 *   }
 * )
 * @ORM\Entity(repositoryClass=SerieRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"seance"="exact"})
 * @ApiFilter(OrderFilter::class, properties={"id","ordre"}, arguments={"orderParameterName"="order"})
 * 
 */
class Serie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"serie:get", "series:get", "seance:get","serie_exercices:get", "seanceSeries:get"})
     */
    private $id;



    /**
     * @ORM\Column(type="integer")
     * @Groups({"serie:get", "series:get", "seance:get","serie_exercices:get", "seanceSeries:get"})
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=Frequence::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"serie:get", "series:get", "seanceSeries:get"})
     */
    private $frequence;

    /**
     * @ORM\OneToMany(targetEntity=SerieExercice::class, mappedBy="serie", cascade={"remove"})
     * @ApiSubresource
     */
    private $serieExercices;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceRealise::class, mappedBy="serie", orphanRemoval=true, cascade={"remove"})
     * @ApiSubresource
     */
    private $exerciceRealises;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="serie", cascade={"remove"})
     * @Groups({"serie:get","serie_exercices:get"})
     * @ApiSubresource
     */
    private $commentaires;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"serie:get", "series:get", "seance:get","serie_exercices:get", "seanceSeries:get"})
     * 
     */
    private $ordre;

    /**
     * @ORM\OneToMany(targetEntity=OccurrenceTime::class, mappedBy="serie", orphanRemoval=true)
     * @ApiSubresource
     */
    private $occurrenceTimes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"serie:get", "series:get", "seance:get","serie_exercices:get", "seanceSeries:get"})
     */
    private $done;

    /**
     * @ORM\OneToMany(targetEntity=SeanceSerie::class, mappedBy="serie", cascade={"remove"})
     */
    private $seanceSeries;


    public function __construct()
    {
        $this->serieExercices = new ArrayCollection();
        $this->exerciceRealises = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->occurrenceTimes = new ArrayCollection();
        $this->seanceSeries = new ArrayCollection();
    }

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

    public function getFrequence(): ?Frequence
    {
        return $this->frequence;
    }

    public function setFrequence(?Frequence $frequence): self
    {
        $this->frequence = $frequence;

        return $this;
    }

    /**
     * @return Collection|SerieExercice[]
     */
    public function getSerieExercices(): Collection
    {
        return $this->serieExercices;
    }

    public function addSerieExercice(SerieExercice $serieExercice): self
    {
        if (!$this->serieExercices->contains($serieExercice)) {
            $this->serieExercices[] = $serieExercice;
            $serieExercice->setSerie($this);
        }

        return $this;
    }

    public function removeSerieExercice(SerieExercice $serieExercice): self
    {
        if ($this->serieExercices->removeElement($serieExercice)) {
            // set the owning side to null (unless already changed)
            if ($serieExercice->getSerie() === $this) {
                $serieExercice->setSerie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExerciceRealise[]
     */
    public function getExerciceRealises(): Collection
    {
        return $this->exerciceRealises;
    }

    public function addExerciceRealise(ExerciceRealise $exerciceRealise): self
    {
        if (!$this->exerciceRealises->contains($exerciceRealise)) {
            $this->exerciceRealises[] = $exerciceRealise;
            $exerciceRealise->setSerie($this);
        }

        return $this;
    }

    public function removeExerciceRealise(ExerciceRealise $exerciceRealise): self
    {
        if ($this->exerciceRealises->removeElement($exerciceRealise)) {
            // set the owning side to null (unless already changed)
            if ($exerciceRealise->getSerie() === $this) {
                $exerciceRealise->setSerie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setSerie($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getSerie() === $this) {
                $commentaire->setSerie(null);
            }
        }

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

    /**
     * @Groups({"serie:get", "series:get", "seance:get","serie_exercices:get"})
     */
    public function getVerouillee()
    {
        if(count($this->getExerciceRealises()) > 0)
        {
            return true;
        }else{
            return false;
        }

    }

    /**
     * @return Collection|OccurrenceTime[]
     */
    public function getOccurrenceTimes(): Collection
    {
        return $this->occurrenceTimes;
    }

    public function addOccurrenceTime(OccurrenceTime $occurrenceTime): self
    {
        if (!$this->occurrenceTimes->contains($occurrenceTime)) {
            $this->occurrenceTimes[] = $occurrenceTime;
            $occurrenceTime->setSerie($this);
        }

        return $this;
    }

    public function removeOccurrenceTime(OccurrenceTime $occurrenceTime): self
    {
        if ($this->occurrenceTimes->removeElement($occurrenceTime)) {
            // set the owning side to null (unless already changed)
            if ($occurrenceTime->getSerie() === $this) {
                $occurrenceTime->setSerie(null);
            }
        }

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

    /**
     * @return Collection|SeanceSerie[]
     */
    public function getSeanceSeries(): Collection
    {
        return $this->seanceSeries;
    }

    public function addSeanceSeries(SeanceSerie $seanceSeries): self
    {
        if (!$this->seanceSeries->contains($seanceSeries)) {
            $this->seanceSeries[] = $seanceSeries;
            $seanceSeries->setSerie($this);
        }

        return $this;
    }

    public function removeSeanceSeries(SeanceSerie $seanceSeries): self
    {
        if ($this->seanceSeries->removeElement($seanceSeries)) {
            // set the owning side to null (unless already changed)
            if ($seanceSeries->getSerie() === $this) {
                $seanceSeries->setSerie(null);
            }
        }

        return $this;
    }

}
