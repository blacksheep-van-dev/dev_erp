<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CalendarClosedDaysRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CalendarClosedDaysRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allCalendarClosedDays']],
    denormalizationContext: ['groups' => ['write:CalendarClosedDays']],
)]
class CalendarClosedDays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read:allCalendarClosedDays'])]
    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[Groups(['read:allCalendarClosedDays'])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $startDate = null;

    #[Groups(['read:allCalendarClosedDays'])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $endDate = null;

    #[Groups(['read:allCalendarClosedDays'])]
    #[ORM\ManyToOne(inversedBy: 'calendarClosedDays')]
    private ?Calendar $calendar = null;

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

    public function getCalendar(): ?Calendar
    {
        return $this->calendar;
    }

    public function setCalendar(?Calendar $calendar): static
    {
        $this->calendar = $calendar;

        return $this;
    }
}
