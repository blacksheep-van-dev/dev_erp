<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CalendarHourRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: CalendarHourRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allCalendarHour']],
    denormalizationContext: ['groups' => ['write:CalendarHour']],
)]

#[Get()]
#[GetCollection()]
#[Post(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_agentComptoir') or is_granted('ROLE_superAdmin')")]
#[Patch(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_agentComptoir') or is_granted('ROLE_superAdmin')")]
#[Put(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_agentComptoir') or is_granted('ROLE_superAdmin')")]   
#[Delete(security:"is_granted('ROLE_adminSociete')")]

class CalendarHour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Groups(['read:allCalendarHour'])]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Groups(['read:allCalendarHour'])]
    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $openFrom = null;

    #[Groups(['read:allCalendarHour'])]
    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $openTo = null;

    #[Groups(['read:allCalendarHour'])]
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
