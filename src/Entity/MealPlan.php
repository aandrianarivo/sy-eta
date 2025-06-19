<?php

namespace App\Entity;

use App\Repository\MealPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MealPlanRepository::class)]
class MealPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateBegin = null;


    /**
     * @var Collection<int, DailyMeal>
     */
    #[ORM\OneToMany(targetEntity: DailyMeal::class, mappedBy: 'mealPlan', orphanRemoval: true)]
    private Collection $dailyMeals;

    public function __construct()
    {
        $this->dailyMeals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
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

    public function getDateBegin(): ?\DateTime
    {
        return $this->dateBegin;
    }

    public function setDateBegin(\DateTime $dateBegin): static
    {
        $this->dateBegin = $dateBegin;

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
            $dailyMeal->setMealPlan($this);
        }

        return $this;
    }

    public function removeDailyMeal(DailyMeal $dailyMeal): static
    {
        if ($this->dailyMeals->removeElement($dailyMeal)) {
            // set the owning side to null (unless already changed)
            if ($dailyMeal->getMealPlan() === $this) {
                $dailyMeal->setMealPlan(null);
            }
        }

        return $this;
    }
}
