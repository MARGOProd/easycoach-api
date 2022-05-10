<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SeanceRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Annotation\UserAware;
/**
 * @ApiResource(
 *  normalizationContext={"groups"={"seances:get"}, "skip_null_values" = false},
 *  denormalizationContext={"groups"={"seance:post"}},
 *  itemOperations={
 *       "get"={"normalization_context"={"groups"="seance:get"}},
 *       "delete",
 *       "put",
 *   }
 * )
 * @ORM\Entity(repositoryClass=SeanceRepository::class)
 */
class Seance implements OwnerForceInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seanceUsers:get", "seance:post", "seance:get", "seances:get", "client:get", "serie:get", "series:get", "seanceSeries:get"})
     */
    private $id;

    // /**
    //  * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="seance")
    //  * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=true)
    //  * @Groups({"seance:post", "seance:get", "seances:get", "series:get"})
    //  */
    // private $client;

    /**
     * @ORM\Column(type="string",)
     * @Groups({"seance:post", "seance:get", "seances:get", "client:get", "serie:get", "series:get", "seanceSeries:get", "seanceUsers:get"})
     */
    private $debut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"seance:post","seance:get", "seances:get", "client:get", "serie:get", "series:get", "seanceSeries:get", "seanceUsers:get"})
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="seances")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * @Groups({"seance:post"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="seance")
     * @Groups({"seance:get"})
     * @ApiSubresource
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=SeanceSerie::class, mappedBy="seance", cascade={"remove"})
     * @ApiSubresource
     */
    private $seanceSeries;

    /**
     * @ORM\OneToMany(targetEntity=SeanceMarque::class, mappedBy="seance")
     * @ApiSubresource
     */
    private $seanceMarques;

    /**
     * @ORM\ManyToOne(targetEntity=SeanceCategorie::class, inversedBy="seances")
     * @Groups({"seances:get", "seance:get", "seanceUsers:get"})
     * @ApiSubresource
     */
    private $seanceCategorie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"seances:get", "seance:get", "seanceUsers:get"})
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=SeanceUser::class, mappedBy="seance")
     * @ApiSubresource
     */
    private $seanceUsers;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="seance")
     */
    private $inscriptions;


    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->seanceSeries = new ArrayCollection();
        $this->seanceMarques = new ArrayCollection();
        $this->seanceUsers = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getClient(): ?Client
    // {
    //     return $this->client;
    // }

    // public function setClient(?Client $client): self
    // {
    //     $this->client = $client;

    //     return $this;
    // }

    public function getDebut(): ?string
    {
        return $this->debut;
    }

    public function setDebut(string $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

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
            $commentaire->setSeance($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getSeance() === $this) {
                $commentaire->setSeance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SeanceSerie[]
     */
    public function getSeanceSeries(): Collection
    {
        return $this->seanceSeries;
    }

    public function addSeanceSeries(SeanceSerie $seanceSeries): self
    {
        if (!$this->seanceSeries->contains($seanceSeries)) {
            $this->seanceSeries[] = $seanceSeries;
            $seanceSeries->setSeance($this);
        }

        return $this;
    }

    public function removeSeanceSeries(SeanceSerie $seanceSeries): self
    {
        if ($this->seanceSeries->removeElement($seanceSeries)) {
            // set the owning side to null (unless already changed)
            if ($seanceSeries->getSeance() === $this) {
                $seanceSeries->setSeance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SeanceMarque[]
     */
    public function getSeanceMarques(): Collection
    {
        return $this->seanceMarques;
    }

    public function addSeanceMarque(SeanceMarque $seanceMarque): self
    {
        if (!$this->seanceMarques->contains($seanceMarque)) {
            $this->seanceMarques[] = $seanceMarque;
            $seanceMarque->setSeance($this);
        }

        return $this;
    }

    public function removeSeanceMarque(SeanceMarque $seanceMarque): self
    {
        if ($this->seanceMarques->removeElement($seanceMarque)) {
            // set the owning side to null (unless already changed)
            if ($seanceMarque->getSeance() === $this) {
                $seanceMarque->setSeance(null);
            }
        }

        return $this;
    }

    public function getSeanceCategorie(): ?SeanceCategorie
    {
        return $this->seanceCategorie;
    }

    public function setSeanceCategorie(?SeanceCategorie $seanceCategorie): self
    {
        $this->seanceCategorie = $seanceCategorie;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|SeanceUser[]
     */
    public function getSeanceUsers(): Collection
    {
        return $this->seanceUsers;
    }

    public function addSeanceUser(SeanceUser $seanceUser): self
    {
        if (!$this->seanceUsers->contains($seanceUser)) {
            $this->seanceUsers[] = $seanceUser;
            $seanceUser->setSeance($this);
        }

        return $this;
    }

    public function removeSeanceUser(SeanceUser $seanceUser): self
    {
        if ($this->seanceUsers->removeElement($seanceUser)) {
            // set the owning side to null (unless already changed)
            if ($seanceUser->getSeance() === $this) {
                $seanceUser->setSeance(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"seances:get", "seance:get"})
     */
    public function getnbSession()
    {
        return count($this->getSeanceUsers());
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setSeance($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getSeance() === $this) {
                $inscription->setSeance(null);
            }
        }

        return $this;
    }

}
