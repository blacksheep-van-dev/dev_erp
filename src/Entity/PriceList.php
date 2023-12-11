<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PriceListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PriceListRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allPriceList']],
    denormalizationContext: ['groups' => ['write:PriceList']],
)]
class PriceList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'priceLists')]
    private ?Agency $agency = null;

    #[ORM\ManyToOne(inversedBy: 'priceLists')]
    private ?ProductCategory $productCategory = null;

    #[ORM\OneToMany(mappedBy: 'priceList', targetEntity: PriceListPrice::class, cascade: ['persist', 'remove'])]
    private Collection $priceListPrices;

    public function __construct()
    {
        $this->priceListPrices = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(?Agency $agency): static
    {
        $this->agency = $agency;

        return $this;
    }

    public function getProductCategory(): ?ProductCategory
    {
        return $this->productCategory;
    }

    public function setProductCategory(?ProductCategory $productCategory): static
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    /**
     * @return Collection<int, PriceListPrice>
     */
    public function getPriceListPrices(): Collection
    {
        return $this->priceListPrices;
    }

    public function addPriceListPrice(PriceListPrice $priceListPrice): static
    {
        if (!$this->priceListPrices->contains($priceListPrice)) {
            $this->priceListPrices->add($priceListPrice);
            $priceListPrice->setPriceList($this);
        }

        return $this;
    }

    public function removePriceListPrice(PriceListPrice $priceListPrice): static
    {
        if ($this->priceListPrices->removeElement($priceListPrice)) {
            // set the owning side to null (unless already changed)
            if ($priceListPrice->getPriceList() === $this) {
                $priceListPrice->setPriceList(null);
            }
        }

        return $this;
    }
}
