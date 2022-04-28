<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SeanceRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Annotation\UserAware;
/**
 * @ApiResource(
 *  normalizationContext={"groups"={"seances:get"}, "skip_null_values" = false},
 *  denormalizationContext={"groups"={"seance:post"}},
 *  itemOperations={
 *       "get"={"normalization_context"={"groups"="seance:get"}},
 *       "delete",
 *       "put",
 *   }
 * )
 * @UserAware(fieldName="user_id")
 * @ORM\Entity(repositoryClass=SeanceRepository::class)
 */
class Seance implements OwnerForceInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:post", "seance:get", "seances:get", "client:get", "serie:get", "series:get", "seanceSeries:get"})
     */
    private $id;

    // /**
    //  * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="seance")
    //  * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=true)
    //  * @Groups({"seance:post", "seance:get", "seances:get", "series:get"})
    //  */
    // private $client;

    /**
     * @ORM\Column(type="string",)
     * @Groups({"seance:post", "seance:get", "seances:get", "client:get", "serie:get", "series:get", "seanceSeries:get"})
     */
    private $debut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"seance:post","seance:get", "seances:get", "client:get", "serie:get", "series:get", "seanceSeries:get"})
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="seances")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * @Groups({"seance:post"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="seance")
     * @Groups({"seance:get"})
     * @ApiSubresource
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=SeanceSerie::class, mappedBy="seance", cascade={"remove"})
     * @ApiSubresource
     */
    private $seanceSeries;

    /**
     * @ORM\OneToMany(targetEntity=SeanceMarque::class, mappedBy="seance")
     * @ApiSubresource
     */
    private $seanceMarques;

    /**
     * @ORM\ManyToOne(targetEntity=SeanceCategorie::class, inversedBy="seances")
     * @Groups({"seances:get", "seance:get"})
     * @ApiSubresource
     */
    private $seanceCategorie;


    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->seanceSeries = new ArrayCollection();
        $this->seanceMarques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getClient(): ?Client
    // {
    //     return $this->client;
    // }

    // public function setClient(?Client $client): self
    // {
    //     $this->client = $client;

    //     return $this;
    // }

    public function getDebut(): ?string
    {
        return $this->debut;
    }

    public function setDebut(string $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $commentaire->setSeance($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getSeance() === $this) {
                $commentaire->setSeance(null);
            }
        }

        return $this;
    }

    // /**
    //  * TODO A REFAIRE
    //  */
    // public function getRepetitionExercice()
    // {
    //     $series = $this->getSeries();
    //     $exerciceRepetitions = array();
    //     if(!$series->isEmpty())
    //     {
    //         foreach($series as $serie)
    //         {
    //             if(!$serie->getExerciceRealises()->isEmpty())
    //             {
    //                 $exercicesRealises = $serie->getExerciceRealises();
    //                 foreach($exercicesRealises as $exercicesRealise )
    //                 {

    //                     if($exercicesRealise->getRepetition() != null)
    //                     {
    //                         if(isset($exerciceRepetitions[$exercicesRealise->getExercice()->getLibelle()]))
    //                         {
    //                             $exerciceRepetitions[$exercicesRealise->getExercice()->getLibelle()]['fait'] += $exercicesRealise->getRepetition();
    //                         }else{
    //                             $exerciceRepetitions += [$exercicesRealise->getExercice()->getLibelle() => ['fait' => $exercicesRealise->getRepetition()]];
    //                         }
    //                     }
    //                     if($exercicesRealise->getSerieExercice() != null && count($exercicesRealise->getSerieExercice())>0 )
    //                     {
    //                         $serieExercice = $exercicesRealise->getSerieExercice();
    //                         if(isset($exerciceRepetitions[$serieExercice->getExercice()->getLibelle()]))
    //                         {
    //                             $exerciceRepetitions[$serieExercice->getExercice()->getLibelle()]+= ['prevu' => $serieExercice->getRepetition()* $serie->getFrequence()->getSets()];
    //                         }else{
    //                             $exerciceRepetitions += [$serieExercice->getExercice()->getLibelle() => ['prevu' => $serieExercice->getRepetition() * $serie->getFrequence()->getSets()]];
    //                         }
    //                     } 
    //                 }
    //             }
    //             if(!$serie->getSerieExercices()->isEmpty())
    //             {
    //                 $exerciceSeriePrevu = $serie->getSerieExercices();
    //                 if(!empty($exerciceRepetitions))
    //                 {
    //                     foreach($exerciceSeriePrevu as $exerciceSeriePrevu)
    //                     {
    //                         if(!isset($exerciceRepetitions[$exerciceSeriePrevu->getExercice()->getLibelle()]))
    //                         {
    //                             $exerciceRepetitions += [$exerciceSeriePrevu->getExercice()->getLibelle() => ['fait' => 0 , 'prevu' => $serieExercice->getRepetition()]];
    //                         }
    //                     }
    //                 }

    //             }
    //         }
    //     }
    //     return $exerciceRepetitions;
    // }

    // /**
    //  * @Groups({"seance:get", "seances:get"})
    //  */
    // public function getPoidsTotal()
    // {
    //     $poids = 0;
    //     if(!empty($this->getExerciceRealise()))
    //     {
    //         $exerciceRealises = $this->getExerciceRealise();
    //         foreach($exerciceRealises as $exerciceRealise)
    //         {
    //             if($exerciceRealise->getPoids() != 0 && $exerciceRealise->getPoids() != null)
    //             {
    //                 $poids += $exerciceRealise->getPoids() * $exerciceRealise->getRepetition();
    //             }
    //         }
    //     }
    //     return $poids;
    // }

    // public function getExerciceRealise()
    // {
    //     $poids = 0;
    //     $series = $this->getSeries();
    //     $exerciceRealises =array();
    //     if(!$series->isEmpty())
    //     {
    //         foreach($series as $serie)
    //         {
    //             if(!$serie->getExerciceRealises()->isEmpty())
    //             {
    //                 foreach($serie->getExerciceRealises() as $exercicesRealise )
    //                 {
    //                     array_push($exerciceRealises, $exercicesRealise);
    //                 }
    //             }
    //         }
    //     }
    //     return $exerciceRealises;
    // }

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
            $seanceSeries->setSeance($this);
        }

        return $this;
    }

    public function removeSeanceSeries(SeanceSerie $seanceSeries): self
    {
        if ($this->seanceSeries->removeElement($seanceSeries)) {
            // set the owning side to null (unless already changed)
            if ($seanceSeries->getSeance() === $this) {
                $seanceSeries->setSeance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SeanceMarque[]
     */
    public function getSeanceMarques(): Collection
    {
        return $this->seanceMarques;
    }

    public function addSeanceMarque(SeanceMarque $seanceMarque): self
    {
        if (!$this->seanceMarques->contains($seanceMarque)) {
            $this->seanceMarques[] = $seanceMarque;
            $seanceMarque->setSeance($this);
        }

        return $this;
    }

    public function removeSeanceMarque(SeanceMarque $seanceMarque): self
    {
        if ($this->seanceMarques->removeElement($seanceMarque)) {
            // set the owning side to null (unless already changed)
            if ($seanceMarque->getSeance() === $this) {
                $seanceMarque->setSeance(null);
            }
        }

        return $this;
    }

    public function getSeanceCategorie(): ?SeanceCategorie
    {
        return $this->seanceCategorie;
    }

    public function setSeanceCategorie(?SeanceCategorie $seanceCategorie): self
    {
        $this->seanceCategorie = $seanceCategorie;

        return $this;
    }

}
