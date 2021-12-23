<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FrequenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=FrequenceRepository::class)
 */
class Frequence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "serie:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "serie:get"})
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"seance:get", "serie:get"})
     */
    private $sets;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSets(): ?int
    {
        return $this->sets;
    }

    public function setSets(int $sets): self
    {
        $this->sets = $sets;

        return $this;
    }
}
