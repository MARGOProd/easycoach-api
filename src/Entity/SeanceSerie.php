<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SeanceSerieRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"seanceSeries:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=SeanceSerieRepository::class)
 */
class SeanceSerie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Seance::class, inversedBy="seanceSeries")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"seanceSeries:get"})
     */
    private $seance;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="seanceSeries")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"seanceSeries:get"})
     */
    private $serie;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }
}
