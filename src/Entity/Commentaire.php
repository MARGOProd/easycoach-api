<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Annotation\UserAware;
 
/**
 * @ApiResource()
 * @UserAware(fieldName="user_id")
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire implements OwnerForceInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "serie:get", "client:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"seance:get", "serie:get"})
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Seance::class, inversedBy="commentaires")
     * @Groups({"serie:get", "client:get"})
     */
    private $seance;

    /**
     * @ORM\Column(type="text")
     * @Groups({"seance:get", "serie:get", "client:get"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="commentaires")
     * @Groups({"seance:get", "client:get"})
     */
    private $serie;

    /**
     * @ORM\ManyToOne(targetEntity=ExerciceRealise::class, inversedBy="commentaires")
     * @Groups({"seance:get", "serie:get", "client:get"})
     */
    private $exerciceRealise;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaires")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=CommentaireMuscle::class, mappedBy="commentaire")
     */
    private $commentaireMuscles;

    public function __construct()
    {
        $this->commentaireMuscles = new ArrayCollection();
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

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): self
    {
        $this->seance = $seance;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getExerciceRealise(): ?ExerciceRealise
    {
        return $this->exerciceRealise;
    }

    public function setExerciceRealise(?ExerciceRealise $exerciceRealise): self
    {
        $this->exerciceRealise = $exerciceRealise;

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
     * @return Collection|CommentaireMuscle[]
     */
    public function getCommentaireMuscles(): Collection
    {
        return $this->commentaireMuscles;
    }

    public function addCommentaireMuscle(CommentaireMuscle $commentaireMuscle): self
    {
        if (!$this->commentaireMuscles->contains($commentaireMuscle)) {
            $this->commentaireMuscles[] = $commentaireMuscle;
            $commentaireMuscle->setCommentaire($this);
        }

        return $this;
    }

    public function removeCommentaireMuscle(CommentaireMuscle $commentaireMuscle): self
    {
        if ($this->commentaireMuscles->removeElement($commentaireMuscle)) {
            // set the owning side to null (unless already changed)
            if ($commentaireMuscle->getCommentaire() === $this) {
                $commentaireMuscle->setCommentaire(null);
            }
        }

        return $this;
    }

}
