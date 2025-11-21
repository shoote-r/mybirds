<?php

namespace App\Entity;

use App\Repository\BirdsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: BirdsRepository::class)]
class Birds
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'birds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Garden $garden = null;

    /**
     * @var Collection<int, Aviary>
     */
    #[ORM\ManyToMany(targetEntity: Aviary::class, mappedBy: 'birds')]
    private Collection $aviaries;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFIlename = null;
    
    private ?File $imageFile = null;

    public function __construct()
    {
        $this->aviaries = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getGarden(): ?Garden
    {
        return $this->garden;
    }

    public function setGarden(?Garden $garden): static
    {
        $this->garden = $garden;

        return $this;
    }

    /**
     * @return Collection<int, Aviary>
     */
    public function getAviaries(): Collection
    {
        return $this->aviaries;
    }

    
    public function addAviary(Aviary $aviary): static
    {
        if (!$this->aviaries->contains($aviary)) {
            $this->aviaries->add($aviary);
            if (!$aviary->getBirds()->contains($this)) {
                $aviary->addBird($this);
            }
        }
        return $this;
    }
    
    public function removeAviary(Aviary $aviary): static
    {
        if ($this->aviaries->removeElement($aviary)) {
            if ($aviary->getBirds()->contains($this)) {
                $aviary->removeBird($this);
            }
        }
        return $this;
    }
    
   
    public function __toString(): string
    {
        return $this->name ?? '';
    }

    public function getImageFIlename(): ?string
    {
        return $this->imageFIlename;
    }

    public function setImageFIlename(?string $imageFIlename): static
    {
        $this->imageFIlename = $imageFIlename;

        return $this;
    }
    
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    
    
    public function setImageFile(?File $imageFile): static
    {
        $this->imageFile = $imageFile;
        return $this;
    }
    
    
}
