<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\PinRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints  as Assert;
use Vich\UploaderBundle\Form\Type\VichFileType;


#[ORM\Entity(repositoryClass: PinRepository::class)]
#[ORM\Table ("pins")]
#[ORM\HasLifecycleCallbacks]

#[Vich\Uploadable]

class Pin
{


    
 
    use Timestampable;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
     
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min:3)]
        
    
    private ?string $title = null;
     
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(min:10)]
        
  
    private ?string $description = null;

    #[ORM\Column ("datetime")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column("DateTimeImmutable")]
    private ?\DateTimeImmutable $updatedAt = null;

    
    // ... other fields

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'pin_image', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;


    #[ORM\Column(length: 255, nullable: true)]

   
    private ?string $imageName = null;

    #[ORM\ManyToOne(inversedBy: 'pins')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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
  
    
    


     public function getImageName(): ?string
     {
         return $this->imageName;
     }
      /**
    
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setupdatedAt ( new \DateTimeImmutable);
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


     public function setImageName(?string $imageName): static
     {
         $this->imageName = $imageName;

         return $this;
     }

     public function getUser(): ?User
     {
         return $this->user;
     }

     public function setUser(?User $user): static
     {
         $this->user = $user;

         return $this;
     }

}
