<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ActivityRepository;
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

#[ApiResource(
    normalizationContext: ['groups' => ['read:allActivity']],
    denormalizationContext: ['groups' => ['write:Activity']],
)]

// Sécurisation des routes par rapport aux RÔLES
#[Get()]
#[GetCollection()]
#[Post(security:"is_granted('ROLE_superAdmin')")]
#[Patch(security: "is_granted('ROLE_superAdmin')")]
#[Put(security: "is_granted('ROLE_superAdmin')")]
#[Delete(security: "is_granted('ROLE_superAdmin')")]


#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read:allActivity', 'write:Activity'])]
    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[Groups(['read:allActivity', 'write:Activity'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Groups(['read:allActivity', 'write:Activity'])]
    #[ORM\Column]
    private ?int $price = null;

    #[Groups(['read:allActivity', 'write:Activity'])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateBegin = null;

    #[Groups(['read:allActivity', 'write:Activity'])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateEnd = null;

    #[Groups(['read:allActivity', 'write:Activity'])]
    #[ORM\OneToMany(mappedBy: 'activity', targetEntity: BookingItem::class)]
    private Collection $bookingItems;

    // #[ORM\ManyToMany(targetEntity: Booking::class, mappedBy: 'activities')]
    // private Collection $bookings;

    #[Groups(['read:allActivity', 'write:Activity'])]
    #[ORM\ManyToOne(inversedBy: 'activities')]
    private ?BookingItem $bookingItem = null;

    public function __construct()
    {
        $this->bookingItems = new ArrayCollection();
        // $this->bookings = new ArrayCollection();
    }


    // to string
    public function __toString()
    {
        return $this->getLabel();
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

    public function getDateBegin(): ?\DateTimeImmutable
    {
        return $this->dateBegin;
    }

    public function setDateBegin(?\DateTimeImmutable $dateBegin): static
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeImmutable
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeImmutable $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

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
            $bookingItem->setActivity($this);
        }

        return $this;
    }

    public function removeBookingItem(BookingItem $bookingItem): static
    {
        if ($this->bookingItems->removeElement($bookingItem)) {
            // set the owning side to null (unless already changed)
            if ($bookingItem->getActivity() === $this) {
                $bookingItem->setActivity(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, Booking>
    //  */
    // public function getBookings(): Collection
    // {
    //     return $this->bookings;
    // }

    // public function addBooking(Booking $booking): static
    // {
    //     if (!$this->bookings->contains($booking)) {
    //         $this->bookings->add($booking);
    //         $booking->addActivity($this);
    //     }

    //     return $this;
    // }

    // public function removeBooking(Booking $booking): static
    // {
    //     if ($this->bookings->removeElement($booking)) {
    //         $booking->removeActivity($this);
    //     }

    //     return $this;
    // }

    public function getBookingItem(): ?BookingItem
    {
        return $this->bookingItem;
    }

    public function setBookingItem(?BookingItem $bookingItem): static
    {
        $this->bookingItem = $bookingItem;

        return $this;
    }
}
