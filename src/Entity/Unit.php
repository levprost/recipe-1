<?php

namespace App\Entity;

use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
class Unit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $unity = null;

    /**
     * @var Collection<int, PostHasIngredient>
     */
    #[ORM\OneToMany(targetEntity: PostHasIngredient::class, mappedBy: 'unit')]
    private Collection $postHasIngredient;

    public function __construct()
    {
        $this->postHasIngredient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnity(): ?string
    {
        return $this->unity;
    }

    public function setUnity(string $unity): static
    {
        $this->unity = $unity;

        return $this;
    }

    /**
     * @return Collection<int, PostHasIngredient>
     */
    public function getPostHasIngredient(): Collection
    {
        return $this->postHasIngredient;
    }

    public function addPostHasIngredient(PostHasIngredient $postHasIngredient): static
    {
        if (!$this->postHasIngredient->contains($postHasIngredient)) {
            $this->postHasIngredient->add($postHasIngredient);
            $postHasIngredient->setUnit($this);
        }

        return $this;
    }

    public function removePostHasIngredient(PostHasIngredient $postHasIngredient): static
    {
        if ($this->postHasIngredient->removeElement($postHasIngredient)) {
            // set the owning side to null (unless already changed)
            if ($postHasIngredient->getUnit() === $this) {
                $postHasIngredient->setUnit(null);
            }
        }

        return $this;
    }
}
