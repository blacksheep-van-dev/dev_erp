<?php

namespace App\Entity;

use App\Entity\Booking;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\ProductsAvailableController;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allProduct']],
    denormalizationContext: ['groups' => ['write:Product']],
    operations: [
        new GetCollection(
            controller: ProductsAvailableController::class,
            name: "Available Product",
            uriTemplate: "products/available/",
            openapiContext: [
                'summary' => 'Find availble products',
            ],
        ),
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['type' => 'exact', 'model' => 'exact', 'productCategory' => 'exact','agency' => 'partial'])]
#[Get()]
#[GetCollection()]
#[Post(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_superAdmin')")]
#[Patch(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_superAdmin')")]
#[Put(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_superAdmin')")]   
#[Delete()]

class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:allProduct'])]
    private ?int $id = null;

    #[Groups(['read:allProduct'])]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Groups(['read:allBookingItem','read:allProduct'])]
    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[Groups(['read:allProduct'])]
    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?BrandModel $model = null;

    #[Groups(['read:allProduct'])]
    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?ProductCategory $productCategory = null;

    #[Groups(['read:allProduct'])]
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: BookingItem::class, cascade: ['persist', 'remove'])]
    private Collection $bookingItems;

    #[Groups(['read:allProduct'])]
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductEvent::class, cascade: ['persist', 'remove'])]
    private Collection $productEvents;

    #[Groups(['read:allProduct'])]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?VehicleDocument $vehicleDocument = null;

    #[ORM\ManyToMany(targetEntity: Booking::class, mappedBy: 'products')]
    private Collection $bookings;

    #[Groups(['read:allProduct'])]
    #[ORM\ManyToOne(inversedBy: 'Products', cascade : ['persist', 'remove'])]
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
