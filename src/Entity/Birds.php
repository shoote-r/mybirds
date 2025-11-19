<?php

namespace App\Entity;

use App\Repository\BirdsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
            $aviary->addBird($this);
        }

        return $this;
    }

    public function removeAviary(Aviary $aviary): static
    {
        if ($this->aviaries->removeElement($aviary)) {
            $aviary->removeBird($this);
        }

        return $this;
    }
}
