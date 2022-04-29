<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SeanceUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=SeanceUserRepository::class)
 */
class SeanceUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Seance::class, inversedBy="seanceUsers")
     */
    private $seance;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="seanceUsers")
     */
    private $user;

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

}
