<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
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

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adress = null;

    /**
     * @var Collection<int, Receipe>
     */
    #[ORM\OneToMany(targetEntity: Receipe::class, mappedBy: 'author', orphanRemoval: true)]
    private Collection $receipes;

    /**
     * @var Collection<int, DailyMeal>
     */
    #[ORM\OneToMany(targetEntity: DailyMeal::class, mappedBy: 'author')]
    private Collection $dailyMeals;

    public function __construct()
    {
        $this->receipes = new ArrayCollection();
        $this->dailyMeals = new ArrayCollection();
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

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return Collection<int, Receipe>
     */
    public function getReceipes(): Collection
    {
        return $this->receipes;
    }

    public function addReceipe(Receipe $receipe): static
    {
        if (!$this->receipes->contains($receipe)) {
            $this->receipes->add($receipe);
            $receipe->setAuthor($this);
        }

        return $this;
    }

    public function removeReceipe(Receipe $receipe): static
    {
        if ($this->receipes->removeElement($receipe)) {
            // set the owning side to null (unless already changed)
            if ($receipe->getAuthor() === $this) {
                $receipe->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DailyMeal>
     */
    public function getDailyMeals(): Collection
    {
        return $this->dailyMeals;
    }

    public function addDailyMeal(DailyMeal $dailyMeal): static
    {
        if (!$this->dailyMeals->contains($dailyMeal)) {
            $this->dailyMeals->add($dailyMeal);
            $dailyMeal->setAuthor($this);
        }

        return $this;
    }

    public function removeDailyMeal(DailyMeal $dailyMeal): static
    {
        if ($this->dailyMeals->removeElement($dailyMeal)) {
            // set the owning side to null (unless already changed)
            if ($dailyMeal->getAuthor() === $this) {
                $dailyMeal->setAuthor(null);
            }
        }

        return $this;
    }
}
