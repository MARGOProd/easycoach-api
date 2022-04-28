<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SeanceCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=SeanceCategorieRepository::class)
 */
class SeanceCategorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SeanceCategorie::class, inversedBy="seanceCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=SeanceCategorie::class, mappedBy="parent")
     */
    private $seanceCategories;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    public function __construct()
    {
        $this->seanceCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSeanceCategories(): Collection
    {
        return $this->seanceCategories;
    }

    public function addSeanceCategory(self $seanceCategory): self
    {
        if (!$this->seanceCategories->contains($seanceCategory)) {
            $this->seanceCategories[] = $seanceCategory;
            $seanceCategory->setParent($this);
        }

        return $this;
    }

    public function removeSeanceCategory(self $seanceCategory): self
    {
        if ($this->seanceCategories->removeElement($seanceCategory)) {
            // set the owning side to null (unless already changed)
            if ($seanceCategory->getParent() === $this) {
                $seanceCategory->setParent(null);
            }
        }

        return $this;
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
}
