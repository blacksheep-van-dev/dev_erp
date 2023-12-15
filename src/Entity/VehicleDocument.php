<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VehicleDocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: VehicleDocumentRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allVehicleDocument']],
    denormalizationContext: ['groups' => ['write:VehicleDocument']],
)]

#[Get()]
#[GetCollection()]
#[Post(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_agentComptoir') or is_granted('ROLE_superAdmin')")]
#[Patch(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_agentComptoir') or is_granted('ROLE_superAdmin')")]
#[Put(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_agentComptoir') or is_granted('ROLE_superAdmin')")]   
#[Delete(security:"is_granted('ROLE_adminSociete')")]

class VehicleDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:allVehicleDocument','read:allProduct'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['read:allVehicleDocument'])]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[Groups(['read:allProduct','read:allVehicleDocument'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[Groups(['read:allProduct','read:allVehicleDocument'])]
    #[ORM\Column(length: 255)]
    private ?string $immatriculation = null;

    #[Groups(['read:allProduct','read:allVehicleDocument'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $immatriculationDate = null;

    #[Groups(['read:allProduct','read:allVehicleDocument'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[Groups(['read:allProduct'])]
    #[ORM\Column(length: 255)]
    private ?string $imageFront = null;

    #[Groups(['read:allProduct'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageBack = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getImmatriculationDate(): ?\DateTimeInterface
    {
        return $this->immatriculationDate;
    }

    public function setImmatriculationDate(\DateTimeInterface $immatriculationDate): static
    {
        $this->immatriculationDate = $immatriculationDate;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getImageFront(): ?string
    {
        return $this->imageFront;
    }

    public function setImageFront(string $imageFront): static
    {
        $this->imageFront = $imageFront;

        return $this;
    }

    public function getImageBack(): ?string
    {
        return $this->imageBack;
    }

    public function setImageBack(?string $imageBack): static
    {
        $this->imageBack = $imageBack;

        return $this;
    }



   
}
