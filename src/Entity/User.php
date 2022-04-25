<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Annotation\UserAware;
/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="user",
 *     message="This email already exists."
 * )
 * @ApiFilter(OrderFilter::class, properties={"id", "prenom" : "DESC", "nom"}, arguments={"orderParameterName"="order"})
 * @UserAware(fieldName="id")
*/
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"device:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Groups({"device:get"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Groups({"device:get"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255,  unique=true)
     * @Groups({"device:get"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     * @Groups({"device:get"})
     */
    private $roles = [];


    /**
     * @ORM\OneToMany(targetEntity=Device::class, mappedBy="user")
     */
    private $devices;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="user")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity=Seance::class, mappedBy="user")
     */
    private $seances;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="user")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Exercice::class, mappedBy="user")
     */
    private $exercices;

    /**
     * @ORM\OneToMany(targetEntity=UserExercice::class, mappedBy="user")
     */
    private $userExercices;

    /**
     * @ORM\OneToMany(targetEntity=UserMarque::class, mappedBy="user")
     */
    private $userMarques;

    /**
     * @ORM\OneToMany(targetEntity=ExerciceRealise::class, mappedBy="user")
     */
    private $exerciceRealises;


    public function __construct()
    {
        $this->devices = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->seances = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->exercices = new ArrayCollection();
        $this->userExercices = new ArrayCollection();
        $this->userMarques = new ArrayCollection();
        $this->exerciceRealises = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    // public function getPassword(): ?string
    // {
    //     return $this->password;
    // }

    // public function setPassword(string $password): self
    // {
    //     $this->password = $password;

    //     return $this;
    // }

    public function getRoles(): ?array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }


    /**
     * @see UserInterface
     */
    public function getUserIdentifier()
    {
        return (string) $this->email;
    }

     /**
     * @see UserInterface
     */
    public function getUsername()
    {
        return (string) $this->email;
    }

    /**
     * @return Collection|Device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
            $device->setUser($this);
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        if ($this->devices->removeElement($device)) {
            // set the owning side to null (unless already changed)
            if ($device->getUser() === $this) {
                $device->setUser(null);
            }
        }

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
            $client->setUser($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getUser() === $this) {
                $client->setUser(null);
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
            $seance->setUser($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seances->removeElement($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getUser() === $this) {
                $seance->setUser(null);
            }
        }

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
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
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
            $exercice->setUser($this);
        }

        return $this;
    }

    public function removeExercice(Exercice $exercice): self
    {
        if ($this->exercices->removeElement($exercice)) {
            // set the owning side to null (unless already changed)
            if ($exercice->getUser() === $this) {
                $exercice->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserExercice[]
     */
    public function getUserExercices(): Collection
    {
        return $this->userExercices;
    }

    public function addUserExercice(UserExercice $userExercice): self
    {
        if (!$this->userExercices->contains($userExercice)) {
            $this->userExercices[] = $userExercice;
            $userExercice->setUser($this);
        }

        return $this;
    }

    public function removeUserExercice(UserExercice $userExercice): self
    {
        if ($this->userExercices->removeElement($userExercice)) {
            // set the owning side to null (unless already changed)
            if ($userExercice->getUser() === $this) {
                $userExercice->setUser(null);
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
            $userMarque->setUser($this);
        }

        return $this;
    }

    public function removeUserMarque(UserMarque $userMarque): self
    {
        if ($this->userMarques->removeElement($userMarque)) {
            // set the owning side to null (unless already changed)
            if ($userMarque->getUser() === $this) {
                $userMarque->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExerciceRealise[]
     */
    public function getExerciceRealises(): Collection
    {
        return $this->exerciceRealises;
    }

    public function addExerciceRealise(ExerciceRealise $exerciceRealise): self
    {
        if (!$this->exerciceRealises->contains($exerciceRealise)) {
            $this->exerciceRealises[] = $exerciceRealise;
            $exerciceRealise->setUser($this);
        }

        return $this;
    }

    public function removeExerciceRealise(ExerciceRealise $exerciceRealise): self
    {
        if ($this->exerciceRealises->removeElement($exerciceRealise)) {
            // set the owning side to null (unless already changed)
            if ($exerciceRealise->getUser() === $this) {
                $exerciceRealise->setUser(null);
            }
        }

        return $this;
    }
    
    
}
