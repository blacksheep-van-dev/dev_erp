<?php

namespace App\Entity;

use App\Repository\CalendarHourRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalendarHourRepository::class)]
class CalendarHour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $openFrom = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $openTo = null;

    #[ORM\ManyToOne(inversedBy: 'calendarHours')]
    private ?CalendarDay $day = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOpenFrom(): ?\DateTimeImmutable
    {
        return $this->openFrom;
    }

    public function setOpenFrom(\DateTimeImmutable $openFrom): static
    {
        $this->openFrom = $openFrom;

        return $this;
    }

    public function getOpenTo(): ?\DateTimeImmutable
    {
        return $this->openTo;
    }

    public function setOpenTo(\DateTimeImmutable $openTo): static
    {
        $this->openTo = $openTo;

        return $this;
    }

    public function getDay(): ?CalendarDay
    {
        return $this->day;
    }

    public function setDay(?CalendarDay $day): static
    {
        $this->day = $day;

        return $this;
    }
}
