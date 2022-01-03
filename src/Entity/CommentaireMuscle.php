<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentaireMuscleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CommentaireMuscleRepository::class)
 */
class CommentaireMuscle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Commentaire::class, inversedBy="commentaireMuscles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Muscle::class, inversedBy="commentaireMuscles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $muscle;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?Commentaire
    {
        return $this->commentaire;
    }

    public function setCommentaire(?Commentaire $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getMuscle(): ?Muscle
    {
        return $this->muscle;
    }

    public function setMuscle(?Muscle $muscle): self
    {
        $this->muscle = $muscle;

        return $this;
    }

}
