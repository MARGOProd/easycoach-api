<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Annotation\UserAware;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"inscriptions:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 * @UniqueEntity(
 *     fields={"seance" , "user"},
 *     errorPath="Inscription",
 *     message="User déjà inscript à cette séance."
 * )
 * @ApiFilter(SearchFilter::class, properties={"seance.seanceCategorie"="exact", "user.nom"="exact", "seance.id"="exact"  })
 * @UserAware(fieldName="user_id")
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"inscriptions:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Seance::class, inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"inscriptions:get"})
     */
    private $seance;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="inscriptions")
     * @Groups({"inscriptions:get"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="inscriptions")
     */
    private $marque;

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

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }
}
