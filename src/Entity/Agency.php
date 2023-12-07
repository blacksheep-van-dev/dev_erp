<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AgencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: AgencyRepository::class)]
class Agency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'Agencies')]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'bookingAgencySource', targetEntity: Booking::class)]
    private Collection $bookings;

    #[ORM\OneToMany(mappedBy: 'agency', targetEntity: Calendar::class)]
    private Collection $calendars;

    #[ORM\OneToMany(mappedBy: 'agency', targetEntity: PriceList::class)]
    private Collection $priceLists;

    #[ORM\OneToMany(mappedBy: 'Agency', targetEntity: Option::class)]
    private Collection $options;

    #[ORM\OneToMany(mappedBy: 'agency', targetEntity: ProductCategory::class)]
    private Collection $ProductCategories;

    #[ORM\OneToMany(mappedBy: 'agency', targetEntity: Product::class)]
    private Collection $Products;

    #[ORM\OneToMany(mappedBy: 'agency', targetEntity: OptionStock::class)]
    private Collection $optionStocks;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->calendars = new ArrayCollection();
        $this->priceLists = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->ProductCategories = new ArrayCollection();
        $this->Products = new ArrayCollection();
        $this->optionStocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    // to string
    public function __toString(): string
    {
        return $this->name;
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
            $booking->setBookingAgencySource($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getBookingAgencySource() === $this) {
                $booking->setBookingAgencySource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Calendar>
     */
    public function getCalendars(): Collection
    {
        return $this->calendars;
    }

    public function addCalendar(Calendar $calendar): static
    {
        if (!$this->calendars->contains($calendar)) {
            $this->calendars->add($calendar);
            $calendar->setAgency($this);
        }

        return $this;
    }

    public function removeCalendar(Calendar $calendar): static
    {
        if ($this->calendars->removeElement($calendar)) {
            // set the owning side to null (unless already changed)
            if ($calendar->getAgency() === $this) {
                $calendar->setAgency(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PriceList>
     */
    public function getPriceLists(): Collection
    {
        return $this->priceLists;
    }

    public function addPriceList(PriceList $priceList): static
    {
        if (!$this->priceLists->contains($priceList)) {
            $this->priceLists->add($priceList);
            $priceList->setAgency($this);
        }

        return $this;
    }

    public function removePriceList(PriceList $priceList): static
    {
        if ($this->priceLists->removeElement($priceList)) {
            // set the owning side to null (unless already changed)
            if ($priceList->getAgency() === $this) {
                $priceList->setAgency(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, Option>
    //  */
    // public function getOptions(): Collection
    // {
    //     return $this->options;
    // }

    // public function addOption(Option $option): static
    // {
    //     if (!$this->options->contains($option)) {
    //         $this->options->add($option);
    //         $option->setAgency($this);
    //     }

    //     return $this;
    // }

    // public function removeOption(Option $option): static
    // {
    //     if ($this->options->removeElement($option)) {
    //         // set the owning side to null (unless already changed)
    //         if ($option->getAgency() === $this) {
    //             $option->setAgency(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, ProductCategory>
     */
    public function getProductCategories(): Collection
    {
        return $this->ProductCategories;
    }

    public function addProductCategory(ProductCategory $productCategory): static
    {
        if (!$this->ProductCategories->contains($productCategory)) {
            $this->ProductCategories->add($productCategory);
            $productCategory->setAgency($this);
        }

        return $this;
    }

    public function removeProductCategory(ProductCategory $productCategory): static
    {
        if ($this->ProductCategories->removeElement($productCategory)) {
            // set the owning side to null (unless already changed)
            if ($productCategory->getAgency() === $this) {
                $productCategory->setAgency(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->Products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->Products->contains($product)) {
            $this->Products->add($product);
            $product->setAgency($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->Products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getAgency() === $this) {
                $product->setAgency(null);
            }
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
            $optionStock->setAgency($this);
        }

        return $this;
    }

    public function removeOptionStock(OptionStock $optionStock): static
    {
        if ($this->optionStocks->removeElement($optionStock)) {
            // set the owning side to null (unless already changed)
            if ($optionStock->getAgency() === $this) {
                $optionStock->setAgency(null);
            }
        }

        return $this;
    }


}
