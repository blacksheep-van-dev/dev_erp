<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AgencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource(
    normalizationContext: ['groups' => ['read:allAgency']],
    denormalizationContext: ['groups' => ['write:Agency']],
    forceEager: false,
    paginationItemsPerPage: 2,
)]
#[ORM\Entity(repositoryClass: AgencyRepository::class)]
class Agency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read:allAgency','write:Agency','read:allBooking'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[Groups(['read:allAgency', 'write:Agency'])]
    #[ORM\ManyToOne(inversedBy: 'Agencies')]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'bookingAgencySource', targetEntity: Booking::class)]
    private Collection $bookings;

    #[Groups(['read:allAgency', 'write:Agency'])]
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

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'agencies', cascade: ['persist', 'remove'])]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: Address::class, mappedBy: 'agency')]
    private Collection $addresses;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->calendars = new ArrayCollection();
        $this->priceLists = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->ProductCategories = new ArrayCollection();
        $this->Products = new ArrayCollection();
        $this->optionStocks = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->addresses = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): static
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
            $address->addAgency($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): static
    {
        if ($this->addresses->removeElement($address)) {
            $address->removeAgency($this);
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }


}
