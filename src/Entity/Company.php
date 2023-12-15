<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allCompany']],
    denormalizationContext: ['groups' => ['write:Company']],
)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:allAgency','read:allCompany'])]
    private ?int $id = null;

    #[Groups(['read:allAgency','read:allCompany','write:Company'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['write:Company'])]
    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Agency::class)]
    private Collection $Agencies;

    #[Groups(['read:allAgency','read:allCompany','write:Company'])]
    #[ORM\Column(length: 255)]
    private ?string $siren = null;

    #[Groups(['write:Company'])]
    #[ORM\Column(length: 255)]
    private ?string $siret = null;

    #[Groups(['write:Company'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $creationDate = null;

    #[Groups(['write:Company'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tvaintra = null;

    #[ORM\ManyToMany(targetEntity: Address::class, mappedBy: 'company')]
    private Collection $addresses;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->Agencies = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): static
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
            $address->addCompany($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): static
    {
        if ($this->addresses->removeElement($address)) {
            $address->removeCompany($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCompany() === $this) {
                $user->setCompany(null);
            }
        }

        return $this;
    }
}
