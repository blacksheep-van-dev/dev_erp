<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\InsuranceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InsuranceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allInsurance']],
    denormalizationContext: ['groups' => ['write:Insurance']],
)]
class Insurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:allInsurance'])]
    private ?int $id = null;

    #[Groups(['read:allBookingItem','read:allInsurance'])]
    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[Groups(['read:allInsurance'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Groups(['read:allInsurance'])]
    #[ORM\Column]
    private ?int $price = null;

    #[ORM\OneToMany(mappedBy: 'insurance', targetEntity: BookingItem::class)]
    private Collection $bookingItems;

    public function __construct()
    {
        $this->bookingItems = new ArrayCollection();
    }

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
            $bookingItem->setInsurance($this);
        }

        return $this;
    }

    public function removeBookingItem(BookingItem $bookingItem): static
    {
        if ($this->bookingItems->removeElement($bookingItem)) {
            // set the owning side to null (unless already changed)
            if ($bookingItem->getInsurance() === $this) {
                $bookingItem->setInsurance(null);
            }
        }

        return $this;
    }
}
