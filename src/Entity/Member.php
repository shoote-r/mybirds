<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Member implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'member', cascade: ['persist', 'remove'])]
    private ?Garden $garden = null;

    /**
     * @var Collection<int, Aviary>
     */
    #[ORM\OneToMany(targetEntity: Aviary::class, mappedBy: 'member', orphanRemoval: true)]
    private Collection $aviaries;

    public function __construct()
    {
        $this->aviaries = new ArrayCollection();
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

    /**
     * @param list<string> $roles
     */
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

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getGarden(): ?Garden
    {
        return $this->garden;
    }

    public function setGarden(Garden $garden): static
    {
        // set the owning side of the relation if necessary
        if ($garden->getMember() !== $this) {
            $garden->setMember($this);
        }

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
            $aviary->setMember($this);
        }

        return $this;
    }

    public function removeAviary(Aviary $aviary): static
    {
        if ($this->aviaries->removeElement($aviary)) {
            // set the owning side to null (unless already changed)
            if ($aviary->getMember() === $this) {
                $aviary->setMember(null);
            }
        }

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->email ?? 'Unnamed Member';
    }
    
}
