<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allBooking']],
    denormalizationContext: ['groups' => ['write:Booking']],
)]

#[Get()]
#[GetCollection()]
#[Post(security:"is_granted('ROLE_client') or is_granted('ROLE_callCenter')")]
#[Patch(security:"is_granted('ROLE_client') or is_granted('ROLE_callCenter')")]
#[Put(security:"is_granted('ROLE_client') or is_granted('ROLE_callCenter')")]   
#[Delete()]

class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:allBooking'])]
    private ?int $id = null;

    #[Groups(['read:allBookingItem','read:allBooking'])]
    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[Groups(['read:allBookingItem','read:allBooking'])]
    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?User $User = null;

    #[Groups(['read:allBooking'])]
    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Agency $bookingAgencySource = null;

    #[Groups(['read:allBooking'])]
    #[ORM\ManyToOne]
    private ?Agency $bookingAgencyTarget = null;

    #[Groups(['read:allBooking'])]
    #[ORM\OneToMany(mappedBy: 'booking', targetEntity: BookingItem::class, cascade: ['persist', 'remove'])]
    private Collection $bookingItems;

    #[Groups(['read:allBooking'])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateBegin = null;

    #[Groups(['read:allBooking'])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateEnd = null;

    #[Groups(['read:allBooking'])]
    #[ORM\ManyToMany(targetEntity: OptionStock::class, inversedBy: 'bookings')]
    private Collection $OptionStocks;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'products')]
    private Collection $products;

    public function __construct()
    {
        $this->bookingItems = new ArrayCollection();
        $this->OptionStocks = new ArrayCollection();
 
    }



    public function __toString()
    {
        return $this->getReference();
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getBookingAgencySource(): ?Agency
    {
        return $this->bookingAgencySource;
    }

    public function setBookingAgencySource(?Agency $bookingAgencySource): static
    {
        $this->bookingAgencySource = $bookingAgencySource;

        return $this;
    }

    public function getBookingAgencyTarget(): ?Agency
    {
        return $this->bookingAgencyTarget;
    }

    public function setBookingAgencyTarget(?Agency $bookingAgencyTarget): static
    {
        $this->bookingAgencyTarget = $bookingAgencyTarget;

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
            $bookingItem->setBooking($this);
        }

        return $this;
    }

    public function removeBookingItem(BookingItem $bookingItem): static
    {
        if ($this->bookingItems->removeElement($bookingItem)) {
            // set the owning side to null (unless already changed)
            if ($bookingItem->getBooking() === $this) {
                $bookingItem->setBooking(null);
            }
        }

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

    /**
     * @return Collection<int, OptionStock>
     */
    public function getOptionStocks(): Collection
    {
        return $this->OptionStocks;
    }

    public function addOptionStock(OptionStock $optionStock): static
    {
        if (!$this->OptionStocks->contains($optionStock)) {
            $this->OptionStocks->add($optionStock);
        }

        return $this;
    }

    public function removeOptionStock(OptionStock $optionStock): static
    {
        $this->OptionStocks->removeElement($optionStock);

        return $this;
    }



}
