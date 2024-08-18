<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column()]
    private ?int $prepTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $cookingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $restingTime = null;

    #[ORM\Column(nullable: true)]
    private ?int $recipeQuantity = null;

    #[ORM\Column(length: 255)]
    private ?string $abstract = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;
     
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?int $prepaTime = null;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(targetEntity: Step::class, mappedBy: 'post')]
    private Collection $step;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favoris')]
    private Collection $favoris;

    /**
     * @var Collection<int, Step1>
     */
    #[ORM\OneToMany(targetEntity: Step1::class, mappedBy: 'post', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $step1s;

    /**
     * @var Collection<int, PostHasIngredient>
     */

    #[ORM\OneToMany(targetEntity: PostHasIngredient::class, mappedBy: 'post', cascade: ['persist', 'remove'],orphanRemoval: true)]
    private Collection $postHasIngredient;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Rubrik $rubrik = null;

    #[Gedmo\Slug(fields:['title'])]
    #[ORM\Column(length: 128, unique:true)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?bool $isPublished = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->step = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->step1s = new ArrayCollection();
        $this->postHasIngredient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPrepTime(): ?int
    {
        return $this->prepTime;
    }

    public function setPrepTime(?int $prepTime): static
    {
        $this->prepTime = $prepTime;

        return $this;
    }

    public function getCookingTime(): ?\DateTimeInterface
    {
        return $this->cookingTime;
    }

    public function setCookingTime(?\DateTimeInterface $cookingTime): static
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getRestingTime(): ?\DateTimeInterface
    {
        return $this->restingTime;
    }

    public function setRestingTime(?\DateTimeInterface $restingTime): static
    {
        $this->restingTime = $restingTime;

        return $this;
    }

    public function getRecipeQuantity(): ?int
    {
        return $this->recipeQuantity;
    }

    public function setRecipeQuantity(?int $recipeQuantity): static
    {
        $this->recipeQuantity = $recipeQuantity;

        return $this;
    }

    public function getAbstract(): ?string
    {
        return $this->abstract;
    }

    public function setAbstract(string $abstract): static
    {
        $this->abstract = $abstract;

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

   
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPrepaTime(): ?int
    {
        return $this->prepaTime;
    }

    public function setPrepaTime(?int $prepaTime): static
    {
        $this->prepaTime = $prepaTime;

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getStep(): Collection
    {
        return $this->step;
    }

    public function addStep(Step $step): static
    {
        if (!$this->step->contains($step)) {
            $this->step->add($step);
            $step->setPost($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->step->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getPost() === $this) {
                $step->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(User $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(User $favori): static
    {
        $this->favoris->removeElement($favori);

        return $this;
    }

    /**
     * @return Collection<int, Step1>
     */
    public function getStep1s(): Collection
    {
        return $this->step1s;
    }

    public function addStep1(Step1 $step1): self
    {
        if (!$this->step1s->contains($step1)) {
            $this->step1s->add($step1);
            $step1->setPost($this);
        }

        return $this;
    }

    public function removeStep1(Step1 $step1): self
    {
        if ($this->step1s->removeElement($step1)) {
            // set the owning side to null (unless already changed)
            if ($step1->getPost() === $this) {
                $step1->setPost(null);
            }
        }

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
            $postHasIngredient->setPost($this);
        }

        return $this;
    }

    public function removePostHasIngredient(PostHasIngredient $postHasIngredient): static
    {
        if ($this->postHasIngredient->removeElement($postHasIngredient)) {
            // set the owning side to null (unless already changed)
            if ($postHasIngredient->getPost() === $this) {
                $postHasIngredient->setPost(null);
            }
        }

        return $this;
    }

    public function getRubrik(): ?Rubrik
    {
        return $this->rubrik;
    }

    public function setRubrik(?Rubrik $rubrik): static
    {
        $this->rubrik = $rubrik;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /*public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }*/

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
