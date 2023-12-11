<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OptionStockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OptionStockRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allOptionStock']],
    denormalizationContext: ['groups' => ['write:OptionStock']],
)]
class OptionStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read:allAgency','read:allOptionStock'])]
    #[ORM\Column]
    private ?int $quantity = null;


    #[Groups(['read:allOptionStock'])]
    #[ORM\ManyToOne(inversedBy: 'optionStocks')]
    private ?Agency $agency = null;

    #[ORM\Column]
    private ?bool $enabled = null;

    #[Groups(['read:allAgency','read:allOptionStock'])]
    #[ORM\Column]
    private ?int $price = null;

    #[Groups(['read:allAgency','read:allOptionStock'])]
    #[ORM\ManyToOne(inversedBy: 'optionStocks')]
    private ?Option $options = null;

    #[ORM\OneToMany(mappedBy: 'OptionStock', targetEntity: BookingItemOption::class)]
    private Collection $bookingItemOptions;

    #[ORM\ManyToMany(targetEntity: Booking::class, mappedBy: 'OptionStocks')]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookingItemOptions = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

  public function __toString()
    {
        // return option label by option stock
        return $this->getOptions()->getLabel().' - '.$this->getAgency()->getName();
    }
        

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

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

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

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

    public function getOptions(): ?Option
    {
        return $this->options;
    }

    public function setOptions(?Option $options): static
    {
        $this->options = $options;

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
            $bookingItemOption->setOptionStock($this);
        }

        return $this;
    }

    public function removeBookingItemOption(BookingItemOption $bookingItemOption): static
    {
        if ($this->bookingItemOptions->removeElement($bookingItemOption)) {
            // set the owning side to null (unless already changed)
            if ($bookingItemOption->getOptionStock() === $this) {
                $bookingItemOption->setOptionStock(null);
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
            $booking->addOptionStock($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            $booking->removeOptionStock($this);
        }

        return $this;
    }

}
