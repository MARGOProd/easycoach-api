<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SeanceUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Traits\TimestampableTrait;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"seanceUsers:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=SeanceUserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ApiFilter(SearchFilter::class, properties={"user.id"="exact"})"})
 * 
 * 
 */
class SeanceUser
{
    use TimestampableTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seanceUsers:get", "seance:get",})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Seance::class, inversedBy="seanceUsers")
     * @Groups({"seanceUsers:get", "seance:get",})
     * @ApiSubresource
     */
    private $seance;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="seanceUsers")
     * @Groups({"seanceUsers:get", "seance:get",})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceRealise::class, mappedBy="seanceUser")
     * @ApiSubresource
     */
    private $exerciceRealises;


    public function __construct()
    {
        $this->exerciceRealises = new ArrayCollection();
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
            $exerciceRealise->setSeanceUser($this);
        }

        return $this;
    }

    public function removeExerciceRealise(ExerciceRealise $exerciceRealise): self
    {
        if ($this->exerciceRealises->removeElement($exerciceRealise)) {
            // set the owning side to null (unless already changed)
            if ($exerciceRealise->getSeanceUser() === $this) {
                $exerciceRealise->setSeanceUser(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"seanceUsers:get", "seance:get",})
     */
    public function getCreated(){
        return $this->createdAt;
    }

}
