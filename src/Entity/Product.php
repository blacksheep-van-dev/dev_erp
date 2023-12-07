<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?BrandModel $model = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?ProductCategory $productCategory = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: BookingItem::class)]
    private Collection $bookingItems;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductEvent::class)]
    private Collection $productEvents;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?VehicleDocument $vehicleDocument = null;

    #[ORM\ManyToMany(targetEntity: Booking::class, mappedBy: 'products')]
    private Collection $bookings;

    #[ORM\ManyToOne(inversedBy: 'Products')]
    private ?Agency $agency = null;

    public function __construct()
    {
        $this->bookingItems = new ArrayCollection();
        $this->productEvents = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->getLabel();
    }



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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getModel(): ?BrandModel
    {
        return $this->model;
    }

    public function setModel(?BrandModel $model): static
    {
        $this->model = $model;

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
     * @return Collection<int, BookingItem>
     */
    public function getBookingItems(): Collection
    {
        return $this->bookingItems;
    }

    public function addBookingItem(BookingItem $bookingItem): static
    {
        if (!$this->bookingItems->contains($bookingItem)) {
            $this->bookingItems->add($bookingItem);
            $bookingItem->setProduct($this);
        }

        return $this;
    }

    public function removeBookingItem(BookingItem $bookingItem): static
    {
        if ($this->bookingItems->removeElement($bookingItem)) {
            // set the owning side to null (unless already changed)
            if ($bookingItem->getProduct() === $this) {
                $bookingItem->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductEvent>
     */
    public function getProductEvents(): Collection
    {
        return $this->productEvents;
    }

    public function addProductEvent(ProductEvent $productEvent): static
    {
        if (!$this->productEvents->contains($productEvent)) {
            $this->productEvents->add($productEvent);
            $productEvent->setProduct($this);
        }

        return $this;
    }

    public function removeProductEvent(ProductEvent $productEvent): static
    {
        if ($this->productEvents->removeElement($productEvent)) {
            // set the owning side to null (unless already changed)
            if ($productEvent->getProduct() === $this) {
                $productEvent->setProduct(null);
            }
        }

        return $this;
    }

    public function getVehicleDocument(): ?VehicleDocument
    {
        return $this->vehicleDocument;
    }

    public function setVehicleDocument(?VehicleDocument $vehicleDocument): static
    {
        $this->vehicleDocument = $vehicleDocument;

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
            $booking->addProduct($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            $booking->removeProduct($this);
        }

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
}
