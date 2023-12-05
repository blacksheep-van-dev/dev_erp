<?php

namespace App\Entity;

use App\Repository\BookingItemOptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingItemOptionRepository::class)]
class BookingItemOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'bookingItemOptions')]
    private ?BookingItem $bookingItem = null;

    #[ORM\ManyToOne(inversedBy: 'bookingItemOptions')]
    private ?OptionStock $OptionStock = null;


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

    public function getBookingItem(): ?BookingItem
    {
        return $this->bookingItem;
    }

    public function setBookingItem(?BookingItem $bookingItem): static
    {
        $this->bookingItem = $bookingItem;

        return $this;
    }

    public function getOptionStock(): ?OptionStock
    {
        return $this->OptionStock;
    }

    public function setOptionStock(?OptionStock $OptionStock): static
    {
        $this->OptionStock = $OptionStock;

        return $this;
    }


}
