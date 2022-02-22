<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserExerciceRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Annotation\UserAware;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"user_exercices:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=UserExerciceRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"exercice.id"="exact"})
 * @UserAware(fieldName="user_id")
 */
class UserExercice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user_exercices:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userExercices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user_exercices:get"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Exercice::class, inversedBy="userExercices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user_exercices:get"})
     */
    private $exercice;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     * @Groups({"user_exercices:get"})
     */
    private $poidsMax;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): self
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getPoidsMax(): ?string
    {
        return $this->poidsMax;
    }

    public function setPoidsMax(?string $poidsMax): self
    {
        $this->poidsMax = $poidsMax;

        return $this;
    }
}
