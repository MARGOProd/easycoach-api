<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExerciceRealiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"exerciceRealises:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=ExerciceRealiseRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"occurrence"="exact"})
 */
class ExerciceRealise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"exerciceRealises:get", "serie:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"exerciceRealises:get", "serie:get"})
     */
    private $repetition;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"exerciceRealises:get", "serie:get"})
     */
    private $occurrence;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"exerciceRealises:get", "serie:get"})
     */
    private $poids;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="exerciceRealises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serie;

    /**
     * @ORM\ManyToOne(targetEntity=SerieExercice::class)
     * @Groups({"serie:get"})
     */
    private $serieExercice;

    /**
     * @ORM\ManyToOne(targetEntity=Exercice::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"exerciceRealises:get", "serie:get"})
     */
    private $exercice;

    /**
     * @ORM\ManyToOne(targetEntity=Materiel::class, inversedBy="exerciceRealises")
     * @Groups({"exerciceRealises:get", "serie:get"})
     */
    private $materiel;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="exerciceRealise")
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOccurrence(): ?int
    {
        return $this->occurrence;
    }

    public function setOccurrence(int $occurrence): self
    {
        $this->occurrence = $occurrence;

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

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getSerieExercice(): ?SerieExercice
    {
        return $this->serieExercice;
    }

    public function setSerieExercice(?SerieExercice $serieExercice): self
    {
        $this->serieExercice = $serieExercice;

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

    public function getMateriel(): ?Materiel
    {
        return $this->materiel;
    }

    public function setMateriel(?Materiel $materiel): self
    {
        $this->materiel = $materiel;

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
            $commentaire->setExerciceRealise($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getExerciceRealise() === $this) {
                $commentaire->setExerciceRealise(null);
            }
        }

        return $this;
    }


}
