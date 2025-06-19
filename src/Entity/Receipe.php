<?php

namespace App\Entity;

use App\Repository\ReceipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReceipeRepository::class)]
class Receipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?float $preparationTime = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $cookingTime = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $difficulty = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $category = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?int $coast = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $keyword = null;

    #[ORM\ManyToOne(inversedBy: 'receipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    /**
     * @var Collection<int, DailyMeal>
     */
    #[ORM\ManyToMany(targetEntity: DailyMeal::class, mappedBy: 'receipes')]
    private Collection $dailyMeals;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\OneToMany(targetEntity: Ingredient::class, mappedBy: 'recipe')]
    private Collection $ingredients;

    public function __construct()
    {
        $this->dailyMeals = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
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

    public function getPreparationTime(): ?float
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(?float $preparationTime): static
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function getCookingTime(): ?string
    {
        return $this->cookingTime;
    }

    public function setCookingTime(?string $cookingTime): static
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(?string $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getCategory(): ?array
    {
        return $this->category;
    }

    public function setCategory(?array $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCoast(): ?int
    {
        return $this->coast;
    }

    public function setCoast(?int $coast): static
    {
        $this->coast = $coast;

        return $this;
    }

    public function getKeyword(): ?array
    {
        return $this->keyword;
    }

    public function setKeyword(?array $keyword): static
    {
        $this->keyword = $keyword;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

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
            $dailyMeal->addReceipe($this);
        }

        return $this;
    }

    public function removeDailyMeal(DailyMeal $dailyMeal): static
    {
        if ($this->dailyMeals->removeElement($dailyMeal)) {
            $dailyMeal->removeReceipe($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecipe() === $this) {
                $ingredient->setRecipe(null);
            }
        }

        return $this;
    }
}
