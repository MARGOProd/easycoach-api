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
     * @Groups({"serie:get", "series:get", "seance:get","serie_exercices:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Seance::class, inversedBy="series")
     */
    private $seance;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"serie:get", "series:get", "seance:get","serie_exercices:get"})
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=Frequence::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"serie:get", "series:get"})
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
     * @Groups({"serie:get", "series:get", "seance:get","serie_exercices:get"})
     * 
     */
    private $ordre;

    public function __construct()
    {
        $this->serieExercices = new ArrayCollection();
        $this->exerciceRealises = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): self
    {
        $this->seance = $seance;

        return $this;
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

}
