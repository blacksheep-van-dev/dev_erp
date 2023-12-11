<?php

namespace App\Entity;

use App\Entity\Agency;
use App\Entity\Company;
use App\Entity\User;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ApiResource]

#[Get()]
#[GetCollection()]
#[Post(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_superAdmin')")]
#[Patch(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_superAdmin')")]
#[Put(security:"is_granted('ROLE_adminSociete') or is_granted('ROLE_respAgence') or is_granted('ROLE_superAdmin')")]   
#[Delete(security:"is_granted('ROLE_adminSociete')")]

class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numStreet = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: agency::class, inversedBy: 'addresses')]
    private Collection $agency;

    #[ORM\ManyToMany(targetEntity: company::class, inversedBy: 'addresses')]
    private Collection $company;

    #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'addresses')]
    private Collection $user;

    public function __construct()
    {
        $this->agency = new ArrayCollection();
        $this->company = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getNumStreet(): ?string
    {
        return $this->numStreet;
    }

    public function setNumStreet(?string $numStreet): static
    {
        $this->numStreet = $numStreet;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
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
     * @return Collection<int, agency>
     */
    public function getAgency(): Collection
    {
        return $this->agency;
    }

    public function addAgency(agency $agency): static
    {
        if (!$this->agency->contains($agency)) {
            $this->agency->add($agency);
        }

        return $this;
    }

    public function removeAgency(agency $agency): static
    {
        $this->agency->removeElement($agency);

        return $this;
    }

    /**
     * @return Collection<int, company>
     */
    public function getCompany(): Collection
    {
        return $this->company;
    }

    public function addCompany(company $company): static
    {
        if (!$this->company->contains($company)) {
            $this->company->add($company);
        }

        return $this;
    }

    public function removeCompany(company $company): static
    {
        $this->company->removeElement($company);

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(user $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(user $user): static
    {
        $this->user->removeElement($user);

        return $this;
    }
}
