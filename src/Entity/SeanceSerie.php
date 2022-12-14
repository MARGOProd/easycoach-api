<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SeanceSerieRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Annotation\ApiFilter;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"seanceSeries:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=SeanceSerieRepository::class)
 * @ApiFilter(OrderFilter::class, properties={"ordre" : "DESC",}, arguments={"orderParameterName"="order"})
 */
class SeanceSerie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seanceSeries:get"})
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

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"seanceSeries:get"})
     */
    private $ordre;

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

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(?int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }
}
