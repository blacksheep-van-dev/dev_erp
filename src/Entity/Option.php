<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`option`')]
#[ApiResource]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $consumable = null;

    #[ORM\Column]
    private ?bool $stockControl = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToMany(targetEntity: ProductCategory::class, inversedBy: 'options')]
    private Collection $productCategories;


    #[ORM\OneToMany(mappedBy: 'options', targetEntity: BookingItemOption::class)]
    private Collection $bookingItemOptions;

    #[ORM\ManyToMany(targetEntity: Booking::class, mappedBy: 'options')]
    private Collection $bookings;

    #[ORM\OneToMany(mappedBy: 'options', targetEntity: OptionStock::class)]
    private Collection $optionStocks;

    public function __construct()
    {
        $this->productCategories = new ArrayCollection();
        $this->bookingItemOptions = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->optionStocks = new ArrayCollection();
    }


    public function __toString(): string
    {
        return $this->label;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function isConsumable(): ?bool
    {
        return $this->consumable;
    }

    public function setConsumable(bool $consumable): static
    {
        $this->consumable = $consumable;

        return $this;
    }

    public function isStockControl(): ?bool
    {
        return $this->stockControl;
    }

    public function setStockControl(bool $stockControl): static
    {
        $this->stockControl = $stockControl;

        return $this;
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

    /**
     * @return Collection<int, ProductCategory>
     */
    public function getProductCategories(): Collection
    {
        return $this->productCategories;
    }

    public function addProductCategory(ProductCategory $productCategory): static
    {
        if (!$this->productCategories->contains($productCategory)) {
            $this->productCategories->add($productCategory);
        }

        return $this;
    }

    public function removeProductCategory(ProductCategory $productCategory): static
    {
        $this->productCategories->removeElement($productCategory);

        return $this;
    }

    /**
     * @return Collection<int, BookingItemOption>
     */
    public function getBookingItemOptions(): Collection
    {
        return $this->bookingItemOptions;
    }

    public function addBookingItemOption(BookingItemOption $bookingItemOption): static
    {
        if (!$this->bookingItemOptions->contains($bookingItemOption)) {
            $this->bookingItemOptions->add($bookingItemOption);
            $bookingItemOption->setOptions($this);
        }

        return $this;
    }

    public function removeBookingItemOption(BookingItemOption $bookingItemOption): static
    {
        if ($this->bookingItemOptions->removeElement($bookingItemOption)) {
            // set the owning side to null (unless already changed)
            if ($bookingItemOption->getOptions() === $this) {
                $bookingItemOption->setOptions(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->addOption($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            $booking->removeOption($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, OptionStock>
     */
    public function getOptionStocks(): Collection
    {
        return $this->optionStocks;
    }

    public function addOptionStock(OptionStock $optionStock): static
    {
        if (!$this->optionStocks->contains($optionStock)) {
            $this->optionStocks->add($optionStock);
            $optionStock->setOptions($this);
        }

        return $this;
    }

    public function removeOptionStock(OptionStock $optionStock): static
    {
        if ($this->optionStocks->removeElement($optionStock)) {
            // set the owning side to null (unless already changed)
            if ($optionStock->getOptions() === $this) {
                $optionStock->setOptions(null);
            }
        }

        return $this;
    }
}
