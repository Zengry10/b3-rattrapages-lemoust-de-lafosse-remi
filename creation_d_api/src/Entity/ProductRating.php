<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\RateProductController;
use App\Repository\ProductRatingRepository;
use App\Request\RateProductRequest;
use App\State\RateProductProcessor;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/products/add-rating",
            controller: RateProductController::class,
            input: RateProductRequest::class,
            processor: RateProductProcessor::class
        )
    ],
    normalizationContext: ["groups" => ["product-rating:read"]]
)]
#[ORM\Entity(repositoryClass: ProductRatingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ProductRating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("product-rating:read")]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'productRatings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("product-rating:read")]
    private ?Product $product = null;

    #[ORM\Column]
    #[Groups("product-rating:read")]
    private ?int $rating = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("product-rating:read")]
    private ?string $note = null;

    #[ORM\Column]
    #[Groups("product-rating:read")]
    private ?DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setDefaults(): void
    {
        $this->setCreatedAt(new DateTimeImmutable());
    }
}
