<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Agency::class)]
    private Collection $Agencies;

    #[ORM\Column(length: 255)]
    private ?string $siren = null;

    #[ORM\Column(length: 255)]
    private ?string $siret = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $creationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tvaintra = null;

    public function __construct()
    {
        $this->Agencies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Agency>
     */
    public function getAgencies(): Collection
    {
        return $this->Agencies;
    }

    public function addAgency(Agency $agency): static
    {
        if (!$this->Agencies->contains($agency)) {
            $this->Agencies->add($agency);
            $agency->setCompany($this);
        }

        return $this;
    }

    public function removeAgency(Agency $agency): static
    {
        if ($this->Agencies->removeElement($agency)) {
            // set the owning side to null (unless already changed)
            if ($agency->getCompany() === $this) {
                $agency->setCompany(null);
            }
        }

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): static
    {
        $this->siren = $siren;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeImmutable
    {
        return $this->creationDate;
    }

    public function setCreationDate(?\DateTimeImmutable $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getTvaintra(): ?string
    {
        return $this->tvaintra;
    }

    public function setTvaintra(?string $tvaintra): static
    {
        $this->tvaintra = $tvaintra;

        return $this;
    }
}
