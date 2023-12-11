<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductEventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductEventRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allProductEvent']],
    denormalizationContext: ['groups' => ['write:ProductEvent']],
)]
class ProductEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read:allProduct','read:allProductEvent'])]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'productEvents')]
    private ?Product $product = null;

    #[Groups(['read:allProduct','read:allProductEvent'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $dateBegin = null;

    #[Groups(['read:allProduct','read:allProductEvent'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $dateEnd = null;

    #[Groups(['read:allProduct','read:allProductEvent'])]
    #[ORM\Column(nullable: true)]
    private ?int $km = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getDateBegin(): ?\DateTimeImmutable
    {
        return $this->dateBegin;
    }

    public function setDateBegin(\DateTimeImmutable $dateBegin): static
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeImmutable
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeImmutable $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(?int $km): static
    {
        $this->km = $km;

        return $this;
    }
}
