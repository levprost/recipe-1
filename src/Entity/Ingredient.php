<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $UpdatedAt = null;

    /**
     * @var Collection<int, PostHasIngredient>
     */
    #[ORM\OneToMany(targetEntity: PostHasIngredient::class, mappedBy: 'ingredient', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $PostHasIngredient;

    public function __construct()
    {
        $this->PostHasIngredient = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->name;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

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
    /**
      *@ORM\PrePersist
     */
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }


    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    /**
     * @return Collection<int, PostHasIngredient>
     */
    public function getPostHasIngredient(): Collection
    {
        return $this->PostHasIngredient;
    }

    public function addPostHasIngredient(PostHasIngredient $postHasIngredient): static
    {
        if (!$this->PostHasIngredient->contains($postHasIngredient)) {
            $this->PostHasIngredient->add($postHasIngredient);
            $postHasIngredient->setIngredient($this);
        }

        return $this;
    }

    public function removePostHasIngredient(PostHasIngredient $postHasIngredient): static
    {
        if ($this->PostHasIngredient->removeElement($postHasIngredient)) {
            // set the owning side to null (unless already changed)
            if ($postHasIngredient->getIngredient() === $this) {
                $postHasIngredient->setIngredient(null);
            }
        }

        return $this;
    }
}
