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
use App\Annotation\UserAware;


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
 * @UserAware(fieldName="user_id")
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ApiFilter(OrderFilter::class, properties={"id", "prenom" : "DESC", "nom"}, arguments={"orderParameterName"="order"})
 */
class Client implements OwnerForceInterface
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

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="clients")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="clients")
     * @ORM\JoinColumn(name="marque_id", referencedColumnName="id", nullable=true)
     */
    private $marque;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="client")
     * @Groups({"client:get"})
     */
    private $commentaires;

    public function __construct()
    {
        $this->seance = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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

    // /**
    //  * @return Collection|Seance[]
    //  */
    // public function getSeance(): Collection
    // {
    //     return $this->seance;
    // }

    // public function addSeance(Seance $seance): self
    // {
    //     if (!$this->seance->contains($seance)) {
    //         $this->seance[] = $seance;
    //         $seance->setClient($this);
    //     }

    //     return $this;
    // }

    // public function removeSeance(Seance $seance): self
    // {
    //     if ($this->seance->removeElement($seance)) {
    //         // set the owning side to null (unless already changed)
    //         if ($seance->getClient() === $this) {
    //             $seance->setClient(null);
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
            $commentaire->setClient($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getClient() === $this) {
                $commentaire->setClient(null);
            }
        }

        return $this;
    }
}
