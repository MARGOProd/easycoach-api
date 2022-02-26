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
     * @ORM\OneToMany(targetEntity=Seance::class, mappedBy="marque")
     */
    private $seances;

    /**
     * @ORM\OneToMany(targetEntity=Exercice::class, mappedBy="marque")
     */
    private $exercices;

    /**
     * @ORM\OneToMany(targetEntity=UserMarque::class, mappedBy="Marque")
     */
    private $userMarques;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->seances = new ArrayCollection();
        $this->exercices = new ArrayCollection();
        $this->userMarques = new ArrayCollection();
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
     * @return Collection|Seance[]
     */
    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seance $seance): self
    {
        if (!$this->seances->contains($seance)) {
            $this->seances[] = $seance;
            $seance->setMarque($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seances->removeElement($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getMarque() === $this) {
                $seance->setMarque(null);
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
}
