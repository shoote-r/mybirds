<?php

namespace App\Entity;

use App\Repository\AviaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AviaryRepository::class)]
class Aviary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;
    
    #[ORM\Column(nullable: true)]
    private ?bool $published = null;
    
    #[ORM\ManyToOne(inversedBy: 'aviaries')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Member $member = null;
    
    /**
     * @var Collection<int, Birds>
     */
    #[ORM\ManyToMany(targetEntity: Birds::class, inversedBy: 'aviaries')]
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
    
    public function isPublished(): ?bool
    {
        return $this->published;
    }
    
    public function setPublished(bool $published): static
    {
        $this->published = $published;
        return $this;
    }
    
    public function getMember(): ?Member
    {
        return $this->member;
    }
    
    public function setMember(?Member $member): static
    {
        $this->member = $member;
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
            
            // synchronisation inverse
            if (!$bird->getAviaries()->contains($this)) {
                $bird->addAviary($this);
            }
        }
        return $this;
    }
    
    public function removeBird(Birds $bird): static
    {
        if ($this->birds->removeElement($bird)) {
            if ($bird->getAviaries()->contains($this)) {
                $bird->removeAviary($this);
            }
        }
        return $this;
    }
    
    /**
     * Pour permettre à Symfony (by_reference=false)
     * de remplacer toute la collection
     */
    public function setBirds(iterable $birds): static
    {
        foreach ($this->birds as $bird) {
            $this->removeBird($bird);
        }
        
        foreach ($birds as $bird) {
            $this->addBird($bird);
        }
        
        return $this;
    }
    
    
}
