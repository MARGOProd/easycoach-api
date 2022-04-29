<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SeanceCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"seanceCategories:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=SeanceCategorieRepository::class)
 * @ApiFilter(ExistsFilter::class, properties={"parent"})
 * @ApiFilter(SearchFilter::class, properties={"parent"="exact"})
 */
class SeanceCategorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "seances:get", "seanceCategories:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SeanceCategorie::class, inversedBy="seanceCategories")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"seance:get", "seances:get", "seanceCategories:get"})
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=SeanceCategorie::class, mappedBy="parent")
     */
    private $seanceCategories;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"seance:get", "seances:get", "seanceCategories:get"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Seance::class, mappedBy="seanceCategorie")
     */
    private $seances;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function __construct()
    {
        $this->seanceCategories = new ArrayCollection();
        $this->seances = new ArrayCollection();
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
            $seance->setSeanceCategorie($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seances->removeElement($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getSeanceCategorie() === $this) {
                $seance->setSeanceCategorie(null);
            }
        }

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
}
