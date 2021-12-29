<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Repository\ClientDataRepository;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={"security"="is_granted('ROLE_USER')"},
 *      },
 *      itemOperations={
 *          "get"={"security"="is_granted('ROLE_ADMIN') or object.user == user"},
 *      },
 *      attributes={"pagination_enabled"=false}
 *  
 * )
 */
class ClientData
{
    /** 
     * @ApiProperty(identifier=true)
     */
    private $id;

    private $type;

    private $resourceId;
 
    private $libelle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getResourceId(): ?int
    {
        return $this->resourceId;
    }

    public function setResourceId(int $resourceId): self
    {
        $this->resourceId = $resourceId;

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
