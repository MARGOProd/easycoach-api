<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;


/**
 * @ApiResource(
*   normalizationContext={"groups"={"clients:get"}, "skip_null_values" = false},
*   itemOperations={
*       "get"={
*           "normalization_context"={"groups"="client:get"},
*       },
*       "delete"
*   }
 * )
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ApiFilter(OrderFilter::class, properties={"id", "prenom" : "DESC", "nom"}, arguments={"orderParameterName"="order"})
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"clients:get", "client:get", "seances:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"clients:get", "client:get", "seances:get"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * * @Groups({"clients:get", "client:get", "seances:get"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"clients:get", "client:get", "seances:get"})
     */
    private $age;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     * @Groups({"clients:get", "client:get", "seances:get"})
     */
    private $poids;

    /**
     * @ORM\OneToMany(targetEntity=Seance::class, mappedBy="client")
     * @Groups({"client:get"})
     */
    private $seance;

    public function __construct()
    {
        $this->seance = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

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

    /**
     * @return Collection|Seance[]
     */
    public function getSeance(): Collection
    {
        return $this->seance;
    }

    public function addSeance(Seance $seance): self
    {
        if (!$this->seance->contains($seance)) {
            $this->seance[] = $seance;
            $seance->setClient($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seance->removeElement($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getClient() === $this) {
                $seance->setClient(null);
            }
        }

        return $this;
    }
}
