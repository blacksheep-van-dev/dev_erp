<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CalendarDayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: CalendarDayRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allCalendarDay']],
    denormalizationContext: ['groups' => ['write:CalendarDay']],
)]

#[Get()]
#[GetCollection()]
#[Post(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_agentComptoir') or is_granted('ROLE_superAdmin')")]
#[Patch(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_agentComptoir') or is_granted('ROLE_superAdmin')")]
#[Put(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_agentComptoir') or is_granted('ROLE_superAdmin')")]   
#[Delete(security:"is_granted('ROLE_adminSociete')")]

class CalendarDay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read:allCalendarDay'])]
    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[Groups(['read:allCalendarDay'])]
    #[ORM\Column]
    private ?bool $open = null;

    #[Groups(['read:allCalendarDay'])]
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
