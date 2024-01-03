<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\UserSearchController;
use App\Controller\UserVerifyController;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allUser']],
    denormalizationContext: ['groups' => ['write:User']],
)]
#[ApiFilter(SearchFilter::class, properties: ['roles' => 'partial', 'id' => 'exact','LastName' => 'partial','firstName' => 'partial','email' => 'partial'])]

#[Get()]
#[Get(
    name:'userSearch',
    uriTemplate:"/user/search/{data}",
    controller:UserSearchController::class,
    openapiContext: [
        'summary' => 'Effectue une recherche sur les champs Prénom/Nom/Email',
        // 'parameters' => ['string'],
    ],
)]

#[GetCollection()]
// #[Post(security:"is_granted('ROLE_callCenter') or is_granted('ROLE_superAdmin')")]
#[Post()]

// Route pour effectuer la vérification
#[Post(
    name:'verifyAction',
    uriTemplate:"/user/verify/{id}",
    controller:UserVerifyController::class
)]

#[Patch(security:"is_granted('ROLE_client') 
            or is_granted('ROLE_superAdmin')")]
            
#[Put(security:"is_granted('ROLE_client') 
            or is_granted('ROLE_superAdmin')")]
            
#[Delete(security:"is_granted('ROLE_client') 
            or is_granted('ROLE_superAdmin')")]



            
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:allBooking','read:allUser'])]
    private ?int $id = null;

    #[Assert\NotBlank(message:'Renseigner un email')]
    #[Groups(['read:allAgency','read:allBookingItem','read:allUser','write:User'])]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    // #[Assert\Choice(choices :["ROLE_USER", "ROLE_agentProd", "ROLE_agentComptoir", "ROLE_callCenter", "ROLE_respAgenceProp", "ROLE_respAgence", "ROLE_adminSociete", "ROLE_respAgenceProp", "ROLE_respAgenceLic"],message:'haha')]
    #[Groups(['read:allUser','write:User'])]
    #[ORM\Column]
    // private $roles = []||"";
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(nullable: true)]
    private ?string $password = null;

    
    #[Assert\NotBlank(message:'Renseigner un Prénom')]
    #[Groups(['read:allAgency','read:allUser','write:User'])]
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    
    #[Assert\NotBlank(message:'Renseigner un Nom')]
    #[Groups(['read:allAgency','read:allUser','write:User'])]
    #[ORM\Column(length: 255)]
    private ?string $LastName = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[Groups(['read:allUser'])]
    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Booking::class)]
    private Collection $bookings;

    
    #[Assert\NotBlank(message:'Renseigner une agence de rattachement')]
    #[Groups(['read:allUser','write:User'])]
    #[ORM\ManyToMany(targetEntity: Agency::class, mappedBy: 'users', cascade: ['persist'])]
    private Collection $agencies;

    #[Groups(['read:allUser'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\ManyToMany(targetEntity: Address::class, mappedBy: 'user')]
    private Collection $addresses;

    
    // #[Assert\NotBlank(message:'Renseigner une société de rattachement')]
    #[Groups(['read:allUser','write:User'])]
    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Company $company = null;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->agencies = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */


     public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
        
    // Modification de SetRoles afin qu'il SET une chaine de caractère
        public function setRoles(array $roles): static
        {
            $this->roles = $roles;

            return $this;
        }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setUser($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getUser() === $this) {
                $booking->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Agency>
     */
    public function getAgencies(): Collection
    {
        return $this->agencies;
    }

    public function addAgency(Agency $agency): static
    {
        if (!$this->agencies->contains($agency)) {
            $this->agencies->add($agency);
            $agency->addUser($this);
        }

        return $this;
    }

    public function removeAgency(Agency $agency): static
    {
        if ($this->agencies->removeElement($agency)) {
            $agency->removeUser($this);
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

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
            $address->addUser($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): static
    {
        if ($this->addresses->removeElement($address)) {
            $address->removeUser($this);
        }

        return $this;
    }


    // return agencies id and names of user
    public function getAgenciesName(): array
    {
        $agenciesName = [];
        foreach ($this->agencies as $agency) {
            $agenciesName[] = [
                'id' =>$agency->getId(),
                'name' =>$agency->getName()
            ];
        }
        return $agenciesName;
    }

    public function getCompany(): ?company
    {
        return $this->company;
    }

    public function setCompany(?company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function __toString()
{
    return $this->firstName . ' ' . $this->LastName;
}

    
    


}
