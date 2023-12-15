<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookingItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookingItemRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allBookingItem']],
    denormalizationContext: ['groups' => ['write:BookingItem']],
)]
class BookingItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:allBooking','read:allBookingItem','read:allProduct'])]
    private ?int $id = null;

    #[Groups(['read:allBookingItem'])]
    #[ORM\Column]
    private ?int $price = null;

    #[Groups(['read:allBookingItem'])]
    #[ORM\Column]
    private ?int $quantity = null;

    #[Groups(['read:allBookingItem'])]
    #[ORM\ManyToOne(inversedBy: 'bookingItems',cascade : ["persist","remove"])]
    private ?Product $product = null;

    #[Groups(['read:allBookingItem'])]
    #[ORM\ManyToOne(inversedBy: 'bookingItems')]
    private ?Activity $activity = null;

    #[Groups(['read:allBookingItem'])]
    #[ORM\ManyToOne(inversedBy: 'bookingItems')]
    private ?Insurance $insurance = null;

    #[Groups(['read:allBookingItem'])]
    #[ORM\ManyToOne(inversedBy: 'bookingItems')]
    private ?Booking $booking = null;

    #[Groups(['read:allBookingItem'])]
    #[ORM\OneToMany(mappedBy: 'bookingItem', targetEntity: Activity::class)]
    private Collection $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

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

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): static
    {
        $this->activity = $activity;

        return $this;
    }

    public function getInsurance(): ?Insurance
    {
        return $this->insurance;
    }

    public function setInsurance(?Insurance $insurance): static
    {
        $this->insurance = $insurance;

        return $this;
    }

    public function getBooking(): ?booking
    {
        return $this->booking;
    }

    public function setBooking(?booking $booking): static
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->setBookingItem($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getBookingItem() === $this) {
                $activity->setBookingItem(null);
            }
        }

        return $this;
    }
}
