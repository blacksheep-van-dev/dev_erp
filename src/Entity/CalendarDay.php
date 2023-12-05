<?php

namespace App\Entity;

use App\Repository\CalendarDayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalendarDayRepository::class)]
class CalendarDay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column]
    private ?bool $open = null;

    #[ORM\OneToMany(mappedBy: 'day', targetEntity: CalendarHour::class)]
    private Collection $calendarHours;

    #[ORM\ManyToOne(inversedBy: 'calendarDays')]
    private ?Calendar $calendar = null;

    public function __construct()
    {
        $this->calendarHours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function isOpen(): ?bool
    {
        return $this->open;
    }

    public function setOpen(bool $open): static
    {
        $this->open = $open;

        return $this;
    }

    /**
     * @return Collection<int, CalendarHour>
     */
    public function getCalendarHours(): Collection
    {
        return $this->calendarHours;
    }

    public function addCalendarHour(CalendarHour $calendarHour): static
    {
        if (!$this->calendarHours->contains($calendarHour)) {
            $this->calendarHours->add($calendarHour);
            $calendarHour->setDay($this);
        }

        return $this;
    }

    public function removeCalendarHour(CalendarHour $calendarHour): static
    {
        if ($this->calendarHours->removeElement($calendarHour)) {
            // set the owning side to null (unless already changed)
            if ($calendarHour->getDay() === $this) {
                $calendarHour->setDay(null);
            }
        }

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
