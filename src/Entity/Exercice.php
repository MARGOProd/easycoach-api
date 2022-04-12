<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExerciceRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Annotation\UserAware;
/**
 * @ApiResource(
 *  normalizationContext={"groups"={"exercices:get"}, "skip_null_values" = false},
 *  denormalizationContext={"groups"={"exercice:post"}},
 *  collectionOperations={
*       "get"={
*           "normalization_context"={"groups"="exercices:get"},
*       },
*       "post"
*   }
 * )
 * @UserAware(fieldName="user_id")
 * @ORM\Entity(repositoryClass=ExerciceRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"libelle"="partial"})
 * @ApiFilter(OrderFilter::class, properties={"id", "libelle"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(ExistsFilter::class, properties={"exerciceCategorie"})
 */
class Exercice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user_exercices:get","exercice:post", "seance:get", "exerciceRealises:get", "serie:get", "series:get", "exercice:get", "exercices:get", "serie_exercices:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_exercices:get","exercice:post", "seance:get", "exerciceRealises:get", "serie:get", "series:get", "exercice:get", "exercices:get", "serie_exercices:get"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceMuscle::class, mappedBy="exercice")
     */
    private $exerciceMuscles;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceMateriel::class, mappedBy="exercice")
     */
    private $exerciceMateriels;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"user_exercices:get", "exercice:post", "seance:get", "exerciceRealises:get", "serie:get", "series:get", "exercice:get", "exercices:get", "serie_exercices:get"})
     */
    private $descriptif;


    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="exercices")
     * @ORM\JoinColumn(name="marque_id", referencedColumnName="id", nullable=true)
     */
    private $marque;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="exercices")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user_exercices:get", "exerciceRealises:get", "serie_exercices:get", "exercice:get", "exercices:get", "exercice:post",})
     */
    private $isPublic;

    /**
     * @ORM\ManyToOne(targetEntity=ExerciceCategorie::class, inversedBy="exercices")
     * @Groups({"exercice:get", "exercices:get", "exercice:post",})
     */
    private $exerciceCategorie;

    /**
     * @ORM\OneToMany(targetEntity=UserExercice::class, mappedBy="exercice")
     */
    private $userExercices;

    public function __construct()
    {
        $this->exerciceMateriels = new ArrayCollection();
        $this->exerciceMuscles = new ArrayCollection();
        $this->userExercices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|ExerciceMuscle[]
     */
    public function getExerciceMuscles(): Collection
    {
        return $this->exerciceMuscles;
    }

    public function addExerciceMuscle(ExerciceMuscle $exerciceMuscle): self
    {
        if (!$this->exerciceMuscles->contains($exerciceMuscle)) {
            $this->exerciceMuscles[] = $exerciceMuscle;
            $exerciceMuscle->setExercice($this);
        }

        return $this;
    }

    public function removeExerciceMuscle(ExerciceMuscle $exerciceMuscle): self
    {
        if ($this->exerciceMuscles->removeElement($exerciceMuscle)) {
            // set the owning side to null (unless already changed)
            if ($exerciceMuscle->getExercice() === $this) {
                $exerciceMuscle->setExercice(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExerciceMateriel[]
     */
    public function getExerciceMateriels(): Collection
    {
        return $this->exerciceMateriels;
    }

    public function addExerciceMateriel(ExerciceMateriel $exerciceMateriel): self
    {
        if (!$this->exerciceMateriels->contains($exerciceMateriel)) {
            $this->exerciceMateriels[] = $exerciceMateriel;
            $exerciceMateriel->setExercice($this);
        }

        return $this;
    }

    public function removeExerciceMateriel(ExerciceMateriel $exerciceMateriel): self
    {
        if ($this->exerciceMateriels->removeElement($exerciceMateriel)) {
            // set the owning side to null (unless already changed)
            if ($exerciceMateriel->getExercice() === $this) {
                $exerciceMateriel->setExercice(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"seance:get", "serie:get", "exerciceRealises:get", "exercice:get"})
     */
    public function getMateriels()
    {
        $materiels =  array();
        foreach($this->exerciceMateriels as $materiel)
        {
            $materiels[] = $materiel->getMateriel();
        }
        return $materiels;
    }

    /**
     */
    public function getMuscles()
    {
        $muscles = array();
        foreach($this->exerciceMuscles as $muscle)
        {
            $muscles[] = $muscle->getMuscle();
        }
        return $muscles;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }


    public function getMarque(): ?marque
    {
        return $this->marque;
    }

    public function setMarque(?marque $marque): self
    {
        $this->marque = $marque;

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

    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(?bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function getExerciceCategorie(): ?ExerciceCategorie
    {
        return $this->exerciceCategorie;
    }

    public function setExerciceCategorie(?ExerciceCategorie $exerciceCategorie): self
    {
        $this->exerciceCategorie = $exerciceCategorie;

        return $this;
    }

    /**
     * @return Collection|UserExercice[]
     */
    public function getUserExercices(): Collection
    {
        return $this->userExercices;
    }

    public function addUserExercice(UserExercice $userExercice): self
    {
        if (!$this->userExercices->contains($userExercice)) {
            $this->userExercices[] = $userExercice;
            $userExercice->setExercice($this);
        }

        return $this;
    }

    public function removeUserExercice(UserExercice $userExercice): self
    {
        if ($this->userExercices->removeElement($userExercice)) {
            // set the owning side to null (unless already changed)
            if ($userExercice->getExercice() === $this) {
                $userExercice->setExercice(null);
            }
        }

        return $this;
    }
}
