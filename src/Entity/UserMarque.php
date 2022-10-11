<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserMarqueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"userMarques:get"}, "skip_null_values" = false},
 * ) 
 * @ApiFilter(SearchFilter::class, properties={"user.nom"="partial", "user.prenom"="partial", "user.id"="exact"})
 * @ApiFilter(OrderFilter::class, properties={"id", "prenom" : "DESC", "nom"}, arguments={"orderParameterName"="order"})
 * @ORM\Entity(repositoryClass=UserMarqueRepository::class)
 */
class UserMarque
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"userMarques:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userMarques")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"userMarques:get"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="userMarques")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"userMarques:get"})
     */
    private $Marque;

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

    public function getMarque(): ?Marque
    {
        return $this->Marque;
    }

    public function setMarque(?Marque $Marque): self
    {
        $this->Marque = $Marque;

        return $this;
    }
}
