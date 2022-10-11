<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeMusculaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"groupeMusculaires:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=GroupeMusculaireRepository::class)
 */
class GroupeMusculaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupeMusculaires:get", "seance:get", "serie:get", "exercice:get", "muscle:get", "exercices:get", "client:get", "commentaireMuscles:get", "exerciceMuscle:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupeMusculaires:get", "seance:get", "serie:get", "exercice:get", "muscle:get", "exercices:get", "client:get", "exerciceMuscle:get"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Muscle::class, mappedBy="groupeMusculaire")
     * @Groups({"groupeMusculaires:get"})
     * @ApiSubresource
     */
    private $muscles;

     /**
     * @Groups({"groupeMusculaires:get", "seance:get", "serie:get", "exercice:get", "muscle:get", "exercices:get", "client:get", "commentaireMuscles:get"})
     */
    public $isSelected;


    public function __construct()
    {
        $this->muscles = new ArrayCollection();
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


    public function getIsSelected()
    {
        return $this->isSelected;
    }

    public function setIsSelected(bool $isSelected): self
    {
        $this->isSelected = $isSelected;
        return $this;
    }

    /**
     * @return Collection|Muscle[]
     */
    public function getMuscles(): Collection
    {
        return $this->muscles;
    }

    public function addMuscle(Muscle $muscle): self
    {
        if (!$this->muscles->contains($muscle)) {
            $this->muscles[] = $muscle;
            $muscle->setGroupeMusculaire($this);
        }

        return $this;
    }

    public function removeMuscle(Muscle $muscle): self
    {
        if ($this->muscles->removeElement($muscle)) {
            // set the owning side to null (unless already changed)
            if ($muscle->getGroupeMusculaire() === $this) {
                $muscle->setGroupeMusculaire(null);
            }
        }

        return $this;
    }
}
