<?php

namespace App\Entity;

use App\Repository\GardenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GardenRepository::class)]
class Garden
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $size = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Birds>
     */
    #[ORM\OneToMany(targetEntity: Birds::class, mappedBy: 'garden', orphanRemoval: true)]
    private Collection $birds;

    public function __construct()
    {
        $this->birds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

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
     * @return Collection<int, Birds>
     */
    public function getBirds(): Collection
    {
        return $this->birds;
    }

    public function addBird(Birds $bird): static
    {
        if (!$this->birds->contains($bird)) {
            $this->birds->add($bird);
            $bird->setGarden($this);
        }

        return $this;
    }

    public function removeBird(Birds $bird): static
    {
        if ($this->birds->removeElement($bird)) {
            // set the owning side to null (unless already changed)
            if ($bird->getGarden() === $this) {
                $bird->setGarden(null);
            }
        }

        return $this;
    }
}
