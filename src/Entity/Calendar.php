<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CalendarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CalendarRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allCalendar']],
    denormalizationContext: ['groups' => ['write:Calendar']],
)]
class Calendar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column]
    private ?bool $blindReturn = null;

    #[ORM\OneToMany(mappedBy: 'calendar', targetEntity: CalendarClosedDays::class)]
    private Collection $calendarClosedDays;

    #[ORM\OneToMany(mappedBy: 'calendar', targetEntity: CalendarDay::class)]
    private Collection $calendarDays;

    #[ORM\ManyToOne(inversedBy: 'calendars')]
    private ?Agency $agency = null;

    public function __construct()
    {
        $this->calendarClosedDays = new ArrayCollection();
        $this->calendarDays = new ArrayCollection();
    }

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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function isBlindReturn(): ?bool
    {
        return $this->blindReturn;
    }

    public function setBlindReturn(bool $blindReturn): static
    {
        $this->blindReturn = $blindReturn;

        return $this;
    }

    /**
     * @return Collection<int, CalendarClosedDays>
     */
    public function getCalendarClosedDays(): Collection
    {
        return $this->calendarClosedDays;
    }

    public function addCalendarClosedDay(CalendarClosedDays $calendarClosedDay): static
    {
        if (!$this->calendarClosedDays->contains($calendarClosedDay)) {
            $this->calendarClosedDays->add($calendarClosedDay);
            $calendarClosedDay->setCalendar($this);
        }

        return $this;
    }

    public function removeCalendarClosedDay(CalendarClosedDays $calendarClosedDay): static
    {
        if ($this->calendarClosedDays->removeElement($calendarClosedDay)) {
            // set the owning side to null (unless already changed)
            if ($calendarClosedDay->getCalendar() === $this) {
                $calendarClosedDay->setCalendar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CalendarDay>
     */
    public function getCalendarDays(): Collection
    {
        return $this->calendarDays;
    }

    public function addCalendarDay(CalendarDay $calendarDay): static
    {
        if (!$this->calendarDays->contains($calendarDay)) {
            $this->calendarDays->add($calendarDay);
            $calendarDay->setCalendar($this);
        }

        return $this;
    }

    public function removeCalendarDay(CalendarDay $calendarDay): static
    {
        if ($this->calendarDays->removeElement($calendarDay)) {
            // set the owning side to null (unless already changed)
            if ($calendarDay->getCalendar() === $this) {
                $calendarDay->setCalendar(null);
            }
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
