<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Traits\Timestampable;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table ("users")]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Timestampable;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
  

    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column ("datetime")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column("DateTimeImmutable")]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Pin::class, orphanRemoval: true)]
    private Collection $pins;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->pins = new ArrayCollection();
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

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        $password = 'password';
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

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
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
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

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
     #[ORM\PrePersist]

     #[ORM\PreUpdate]
    public function updateTimestamps(){
        if ($this->setCreatedAt(new \DateTimeImmutable) ===null) {

        
        $this->setCreatedAt(new \DateTimeImmutable());

        }
        $this->setUpdatedAt(new \DateTimeImmutable());

    }

     /**
      * @return Collection<int, Pin>
      */
     public function getPins(): Collection
     {
         return $this->pins;
     }

     public function addPin(Pin $pin): static
     {
         if (!$this->pins->contains($pin)) {
             $this->pins->add($pin);
             $pin->setUser($this);
         }

         return $this;
     }

     public function removePin(Pin $pin): static
     {
         if ($this->pins->removeElement($pin)) {
             // set the owning side to null (unless already changed)
             if ($pin->getUser() === $this) {
                 $pin->setUser(null);
             }
         }

         return $this;
     } 
       public function password(){

        
        return $this->password;
     
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
    
    
           
}

