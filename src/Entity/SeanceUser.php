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
/**
 * @ApiResource(
 *  normalizationContext={"groups"={"seanceUsers:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=SeanceUserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * 
 */
class SeanceUser
{
    use TimestampableTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seanceUsers:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Seance::class, inversedBy="seanceUsers")
     * @Groups({"seanceUsers:get"})
     * @ApiSubresource
     */
    private $seance;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="seanceUsers")
     * @Groups({"seanceUsers:get"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceRealise::class, mappedBy="seanceUser")
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
     * @Groups({"seanceUsers:get"})
     */
    public function getCreated(){
        return $this->createdAt;
    }

}
