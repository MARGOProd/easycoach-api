<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=MarqueRepository::class)
 */
class Marque
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;


    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="marque")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity=Exercice::class, mappedBy="marque")
     */
    private $exercices;

    /**
     * @ORM\OneToMany(targetEntity=UserMarque::class, mappedBy="Marque")
     */
    private $userMarques;

    /**
     * @ORM\OneToMany(targetEntity=SeanceMarque::class, mappedBy="marque")
     */
    private $seanceMarques;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->exercices = new ArrayCollection();
        $this->userMarques = new ArrayCollection();
        $this->seanceMarques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setMarque($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getMarque() === $this) {
                $client->setMarque(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Exercice[]
     */
    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercice $exercice): self
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices[] = $exercice;
            $exercice->setMarque($this);
        }

        return $this;
    }

    public function removeExercice(Exercice $exercice): self
    {
        if ($this->exercices->removeElement($exercice)) {
            // set the owning side to null (unless already changed)
            if ($exercice->getMarque() === $this) {
                $exercice->setMarque(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserMarque[]
     */
    public function getUserMarques(): Collection
    {
        return $this->userMarques;
    }

    public function addUserMarque(UserMarque $userMarque): self
    {
        if (!$this->userMarques->contains($userMarque)) {
            $this->userMarques[] = $userMarque;
            $userMarque->setMarque($this);
        }

        return $this;
    }

    public function removeUserMarque(UserMarque $userMarque): self
    {
        if ($this->userMarques->removeElement($userMarque)) {
            // set the owning side to null (unless already changed)
            if ($userMarque->getMarque() === $this) {
                $userMarque->setMarque(null);
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
            $seanceMarque->setMarque($this);
        }

        return $this;
    }

    public function removeSeanceMarque(SeanceMarque $seanceMarque): self
    {
        if ($this->seanceMarques->removeElement($seanceMarque)) {
            // set the owning side to null (unless already changed)
            if ($seanceMarque->getMarque() === $this) {
                $seanceMarque->setMarque(null);
            }
        }

        return $this;
    }
}
