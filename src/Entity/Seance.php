<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SeanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Annotation\UserAware;
use App\Annotation\MarqueAware;
/**
 * @ApiResource(
 *  normalizationContext={"groups"={"seances:get"}, "skip_null_values" = false},
 *  denormalizationContext={"groups"={"seance:post"}},
 *  itemOperations={
 *       "get"={"normalization_context"={"groups"="seance:get"}},
 *       "delete",
 *        "put",
 *   }
 * )
 * @MarqueAware(fieldName="marque_id")
 * @UserAware(fieldName="user_id")
 * @ORM\Entity(repositoryClass=SeanceRepository::class)
 */
class Seance implements OwnerForceInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:post", "seance:get", "seances:get", "client:get", "serie:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="seance")
     * @Groups({"seance:post", "seance:get", "seances:get",})
     */
    private $client;

    /**
     * @ORM\Column(type="string",)
     * @Groups({"seance:post", "seance:get", "seances:get", "client:get", "serie:get"})
     */
    private $debut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"seance:post","seance:get", "seances:get", "client:get", "serie:get"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Serie::class, mappedBy="seance")
     * @Groups({"client:get", "seance:get"})
     */
    private $series;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="seances")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * @Groups({"seance:post", "seance:get", "seances:get"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="seances")
     * @ORM\JoinColumn(name="marque_id", referencedColumnName="id", nullable=true)
     * @Groups({"seance:post", "seance:get"})
     */
    private $marque;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"seance:post", "seance:get", "seances:get", "client:get", "serie:get"})
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="seance")
     * @Groups({"seance:get", "seances:get"})
     */
    private $commentaires;

    public function __construct()
    {
        $this->series = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

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

    /**
     * @return Collection|Serie[]
     */
    public function getSeries(): Collection
    {
        return $this->series;
    }

    // public function addSeries(Serie $series): self
    // {
    //     if (!$this->series->contains($series)) {
    //         $this->series[] = $series;
    //         $series->setSeance($this);
    //     }

    //     return $this;
    // }

    // public function removeSeries(Serie $series): self
    // {
    //     if ($this->series->removeElement($series)) {
    //         // set the owning side to null (unless already changed)
    //         if ($series->getSeance() === $this) {
    //             $series->setSeance(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

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

    /**
     * @Groups({"seance:get", "seances:get"})
     */
    public function getRepetitionExercice()
    {
        $series = $this->getSeries();
        $exerciceRepetitions = array();
        if(!$series->isEmpty())
        {
            foreach($series as $serie)
            {
                if(!$serie->getExerciceRealises()->isEmpty())
                {
                    $exercicesRealises = $serie->getExerciceRealises();
                    foreach($exercicesRealises as $exercicesRealise )
                    {

                        if($exercicesRealise->getRepetition() != null)
                        {
                            if(isset($exerciceRepetitions[$exercicesRealise->getExercice()->getLibelle()]))
                            {
                                $exerciceRepetitions[$exercicesRealise->getExercice()->getLibelle()]['fait'] += $exercicesRealise->getRepetition();
                            }else{
                                $exerciceRepetitions += [$exercicesRealise->getExercice()->getLibelle() => ['fait' => $exercicesRealise->getRepetition()]];
                            }
                        }
                        if($exercicesRealise->getSerieExercice() != null)
                        {
                            $serieExercice = $exercicesRealise->getSerieExercice();
                            if(isset($exerciceRepetitions[$serieExercice->getExercice()->getLibelle()]))
                            {
                                $exerciceRepetitions[$serieExercice->getExercice()->getLibelle()]+= ['prevu' => $serieExercice->getRepetition()* $serie->getFrequence()->getSets()];
                            }else{
                                $exerciceRepetitions += [$serieExercice->getExercice()->getLibelle() => ['prevu' => $serieExercice->getRepetition() * $serie->getFrequence()->getSets()]];
                            }
                        } 
                    }
                }
                if(!$serie->getSerieExercices()->isEmpty())
                {
                    $exerciceSeriePrevu = $serie->getSerieExercices();
                    if(!empty($exerciceRepetitions))
                    {
                        foreach($exerciceSeriePrevu as $exerciceSeriePrevu)
                        {
                            if(!isset($exerciceRepetitions[$exerciceSeriePrevu->getExercice()->getLibelle()]))
                            {
                                $exerciceRepetitions += [$exerciceSeriePrevu->getExercice()->getLibelle() => ['fait' => 0 , 'prevu' => $serieExercice->getRepetition()]];
                            }
                        }
                    }

                }
            }
        }
        return $exerciceRepetitions;
    }

}
