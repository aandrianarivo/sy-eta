<?php

namespace App\Entity;

use App\Repository\DailyMealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DailyMealRepository::class)]
class DailyMeal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $MealDate = null;

    /**
     * @var Collection<int, Receipe>
     */
    #[ORM\ManyToMany(targetEntity: Receipe::class, inversedBy: 'dailyMeals')]
    private Collection $receipes;

    #[ORM\ManyToOne(inversedBy: 'dailyMeals')]
    private ?User $author = null;

    public function __construct()
    {
        $this->receipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMealDate(): ?\DateTime
    {
        return $this->MealDate;
    }

    public function setMealDate(?\DateTime $MealDate): static
    {
        $this->MealDate = $MealDate;

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
        }

        return $this;
    }

    public function removeReceipe(Receipe $receipe): static
    {
        $this->receipes->removeElement($receipe);

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
}
