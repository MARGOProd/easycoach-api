<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentaireMuscleRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ApiResource(
 *       normalizationContext={"groups"={"commentaireMuscles:get"}, "skip_null_values" = false},
 *  itemOperations={
*       "get"={
*           "normalization_context"={"groups"="commentaireMuscle:get"},
*       },
*       "delete"
*   }
 * )
 * @ORM\Entity(repositoryClass=CommentaireMuscleRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"commentaire"="exact", "muscle"="exact"}),
 * @UniqueEntity(
 *     fields={"commentaire", "muscle"},
 *     errorPath="CommentaireMuscle",
 *     message="This commentaireMuscle already exists."
 * )
 */
class CommentaireMuscle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"client:get", "commentaireMuscles:get", "commentaireMuscle:get"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Commentaire::class, inversedBy="commentaireMuscles")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"commentaireMuscles:get", "commentaireMuscle:get"})
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Muscle::class, inversedBy="commentaireMuscles")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"client:get", "commentaireMuscles:get", "commentaireMuscle:get"})
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
