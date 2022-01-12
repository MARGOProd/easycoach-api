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
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"exerciceRealises:get", "serie:get"})
     */
    private $duree;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"exerciceRealises:get", "serie:get"})
     */
    private $calorie;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="exerciceRealises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serie;

    /**
     * @ORM\ManyToOne(targetEntity=SerieExercice::class)
     * @Groups({"serie:get", "exerciceRealises:get"})
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

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

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

    /**
     * @Groups({"exerciceRealises:get", "serie:get"})
     */
    public function getTauxRealisation()
    {
        $tauxRealisation = null;
        $ExerciceRealiseCritere = ['rep' => null, 'poids' => null, 'duree' => null, 'cal' => null];
        $ExerciceRealiseCritere['rep'] = $this->getRepetition();
        $ExerciceRealiseCritere['poids'] = $this->getPoids();
        $ExerciceRealiseCritere['duree'] = $this->getDuree();
        $ExerciceRealiseCritere['cal'] = $this->getCalorie();
        if($this->getSerieExercice() != null)
        {
            $exercicePrevu = $this->getSerieExercice();
            $ExercicePrevuCritere = ['rep' => null, 'poids' => null, 'duree' => null, 'cal' => null];
            $ExercicePrevuCritere['rep'] = $exercicePrevu->getRepetition();
            $ExercicePrevuCritere['poids'] = $exercicePrevu->getPoids();
            $ExercicePrevuCritere['duree'] = $exercicePrevu->getDuree();
            $ExercicePrevuCritere['cal'] = $exercicePrevu->getCalorie();

           if($ExerciceRealiseCritere['rep'] != null)
           {
            //    rep * duree
               if($ExerciceRealiseCritere['duree'] != null && $ExerciceRealiseCritere['poids'] == null && $ExerciceRealiseCritere['cal'] == null)
               {
                    if($ExercicePrevuCritere['rep'] != null &&  $ExercicePrevuCritere['duree'] != null && $ExercicePrevuCritere['poids'] == null && $ExercicePrevuCritere['cal'] == null)
                    {
                        $PrevuTotal = $ExercicePrevuCritere['rep'] * $ExercicePrevuCritere['duree'];
                        $RealiseeTotal = $ExerciceRealiseCritere['rep'] * $ExerciceRealiseCritere['duree'];
                        $tauxRealisation = ($RealiseeTotal * 100 ) /  $PrevuTotal;
                    }
               }
            //    rep * poids
               else if($ExerciceRealiseCritere['poids'] != null && $ExerciceRealiseCritere['duree'] == null && $ExerciceRealiseCritere['cal'] == null)
               {
                    if($ExercicePrevuCritere['rep'] != null &&  $ExercicePrevuCritere['poids'] != null && $ExercicePrevuCritere['duree'] == null && $ExercicePrevuCritere['cal'] == null)
                    {
                        $PrevuTotal = $ExercicePrevuCritere['rep'] * $ExercicePrevuCritere['poids'];
                        $RealiseeTotal = $ExerciceRealiseCritere['rep'] * $ExerciceRealiseCritere['poids'];
                        $tauxRealisation = ($RealiseeTotal * 100 ) /  $PrevuTotal;
                    }
               }
            //    rep * cal
               else if($ExerciceRealiseCritere['cal'] != null && $ExerciceRealiseCritere['duree'] == null && $ExerciceRealiseCritere['poids'] == null)
               {
                    if($ExercicePrevuCritere['rep'] != null &&  $ExercicePrevuCritere['cal'] != null && $ExercicePrevuCritere['duree'] == null && $ExercicePrevuCritere['poids'] == null)
                    {
                        $PrevuTotal = $ExercicePrevuCritere['rep'] * $ExercicePrevuCritere['cal'];
                        $RealiseeTotal = $ExerciceRealiseCritere['rep'] * $ExerciceRealiseCritere['cal'];
                        $tauxRealisation = ($RealiseeTotal * 100 ) /  $PrevuTotal;
                    }
               }
            //    rep
               else{
                    if($ExercicePrevuCritere['rep'] != null &&  $ExercicePrevuCritere['cal'] == null && $ExercicePrevuCritere['duree'] == null && $ExercicePrevuCritere['poids'] == null)
                    {
                        $tauxRealisation = ($ExerciceRealiseCritere['rep'] * 100 ) /  $ExercicePrevuCritere['rep'];
                    }
               }

           }

        }

        return $tauxRealisation;
    }

}
