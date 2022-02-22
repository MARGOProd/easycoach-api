<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DeviceRepository;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ApiResource(
 *  normalizationContext={"groups"={"device:get"}, "skip_null_values" = false},
 * )
 * @ORM\Entity(repositoryClass=DeviceRepository::class)
    * @ApiFilter(SearchFilter::class, properties={"deviceKey"="exact"})     
 */
class Device
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"device:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"device:get"})
     */
    private $deviceKey;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="devices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"device:get"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeviceKey(): ?string
    {
        return $this->deviceKey;
    }

    public function setDeviceKey(string $deviceKey): self
    {
        $this->deviceKey = $deviceKey;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
