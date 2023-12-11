<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PriceListPriceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PriceListPriceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allPriceListPrice']],
    denormalizationContext: ['groups' => ['write:PriceListPrice']],
)]
class PriceListPrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read:allPriceListPrice'])]
    #[ORM\Column]
    private ?int $price = null;

    #[Groups(['read:allPriceListPrice'])]
    #[ORM\Column]
    private ?int $minimalDuration = null;

    #[Groups(['read:allPriceListPrice'])]
    #[ORM\Column]
    private ?int $maximalDuration = null;

    #[ORM\ManyToOne(inversedBy: 'priceListPrices', targetEntity: PriceList::class)]
    private ?PriceList $PriceList = null;

    #[ORM\ManyToOne(inversedBy: 'priceListPrices', targetEntity: PriceList::class)]
    private ?PriceList $priceList = null;



    //to string
    public function __toString(): string
    {
        return $this->getPrice() . '€';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getMinimalDuration(): ?int
    {
        return $this->minimalDuration;
    }

    public function setMinimalDuration(int $minimalDuration): static
    {
        $this->minimalDuration = $minimalDuration;

        return $this;
    }

    public function getMaximalDuration(): ?int
    {
        return $this->maximalDuration;
    }

    public function setMaximalDuration(int $maximalDuration): static
    {
        $this->maximalDuration = $maximalDuration;

        return $this;
    }

    public function getPriceList(): ?PriceList
    {
        return $this->PriceList;
    }

    public function setPriceList(?PriceList $PriceList): static
    {
        $this->PriceList = $PriceList;

        return $this;
    }
}
