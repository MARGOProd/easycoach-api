<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * * itemOperations={
 *       "get"={"normalization_context"={"groups"="serie:get"}},
 *       "delete",
 *       "put"
 *   }
 * )
 * @ORM\Entity(repositoryClass=SerieRepository::class)
 */
class Serie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "serie:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Seance::class, inversedBy="series")
     * @Groups({"serie:get"})
     */
    private $seance;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "serie:get"})
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=Frequence::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"seance:get", "serie:get"})
     */
    private $frequence;

    /**
     * @ORM\OneToMany(targetEntity=SerieExercice::class, mappedBy="serie")
     * @Groups({"seance:get", "serie:get"})
     */
    private $serieExercices;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceRealise::class, mappedBy="serie", orphanRemoval=true)
     * @Groups({"seance:get", "serie:get"})
     */
    private $exerciceRealises;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="serie")
     */
    private $commentaires;

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

}
