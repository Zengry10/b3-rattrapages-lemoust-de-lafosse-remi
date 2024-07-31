<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\ProductImageController;
use App\Repository\ProductRepository;
use App\Request\AddToProductStockRequest;
use App\State\AddToProductStockProcessor;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: "/product/{id}"
        ),
        new GetCollection(
            uriTemplate: "/products",
        ),
        new Post(
            uriTemplate: "/products",
            inputFormats: ["multipart" => ["multipart/form-data"]],
            controller: ProductImageController::class,
            denormalizationContext: ["groups" => ["product:create"]],
            security: "is_granted('ROLE_ADMIN')",
            deserialize: false
        ),
        new Patch(
            uriTemplate: "/products/{id}/add-to-stock",
            inputFormats: ["json" => ["application/json"]],
            security: "is_granted('ROLE_ADMIN')",
            input: AddToProductStockRequest::class,
            processor: AddToProductStockProcessor::class,
        )
    ],
    normalizationContext: ["groups" => ["product:read"]],
)]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["product:read", "basket:read", "product-rating:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["product:read", "product:create", "basket:read", "product-rating:read"])]
    #[Assert\Length(min: 3, max: 255)]
    #[Assert\NotBlank(message: "Name is required")]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["product:read", "basket:read", "product-rating:read"])]
    private ?string $imagePath = null;

    #[Vich\UploadableField(
        mapping: 'product_image',
        fileNameProperty: 'imagePath',
    )]
    #[Groups("product:create")]
    #[Assert\Image]
    #[Assert\NotNull]
    #[ApiProperty(openapiContext: ['type' => 'string', 'format' => 'binary'])]
    public ?File $imageFile = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["product:read", "product:create", "basket:read", "product-rating:read"])]
    #[Assert\Length(min: 5)]
    #[Assert\NotBlank(message: "Description is required")]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(["product:read", "product:create", "basket:read", "product-rating:read"])]
    #[Assert\GreaterThan(value: 0)]
    #[Assert\NotBlank(message: "Price is required")]
    private ?int $price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["product:read", "product:create"])]
    private ?string $note = null;

    #[ORM\Column]
    #[Groups(["product:read", "product:create"])]
    #[Assert\GreaterThan(value: 0)]
    private ?int $unitsRemaining = null;

    #[ORM\Column]
    #[Groups("product:read")]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups("product:read")]
    private ?DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, ProductRating>
     */
    #[ORM\OneToMany(targetEntity: ProductRating::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $productRatings;

    public function __construct()
    {
        $this->productRatings = new ArrayCollection();
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

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getUnitsRemaining(): ?int
    {
        return $this->unitsRemaining;
    }

    public function setUnitsRemaining(int $unitsRemaining): static
    {
        $this->unitsRemaining = $unitsRemaining;

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

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setDefaults(): void
    {
        $this->setCreatedAt(new DateTimeImmutable());
    }

    /**
     * @return Collection<int, ProductRating>
     */
    public function getProductRatings(): Collection
    {
        return $this->productRatings;
    }

    public function addProductRating(ProductRating $productRating): static
    {
        if (!$this->productRatings->contains($productRating)) {
            $this->productRatings->add($productRating);
            $productRating->setProduct($this);
        }

        return $this;
    }

    public function removeProductRating(ProductRating $productRating): static
    {
        if ($this->productRatings->removeElement($productRating)) {
            // set the owning side to null (unless already changed)
            if ($productRating->getProduct() === $this) {
                $productRating->setProduct(null);
            }
        }

        return $this;
    }
}
