<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\AddBasketProductController;
use App\Controller\UserBasketController;
use App\Controller\UserCancelBasketController;
use App\Controller\UserCheckoutBasketController;
use App\Repository\BasketRepository;
use App\Request\AddProductToBasketRequest;
use App\State\ActiveUserBasketProvider;
use App\State\CancelBasketProcessor;
use App\State\CheckoutBasketProcessor;
use App\State\ValidateBasketProcessor;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: "/baskets",
            provider: ActiveUserBasketProvider::class
        ),
        new Post(
            uriTemplate: "/baskets",
            controller: AddBasketProductController::class,
            input: AddProductToBasketRequest::class
        ),
        new Post(
            uriTemplate: "/baskets/validate",
            status: Response::HTTP_OK,
            controller: UserBasketController::class,
            input: false,
            processor: ValidateBasketProcessor::class,
        ),
        new Post(
            uriTemplate: "/baskets/checkout",
            status: Response::HTTP_OK,
            controller: UserCheckoutBasketController::class,
            input: false,
            processor: CheckoutBasketProcessor::class,
        ),
        new Post(
            uriTemplate: "/baskets/cancel",
            status: Response::HTTP_OK,
            controller: UserCancelBasketController::class,
            input: false,
            processor: CancelBasketProcessor::class
        )
    ],
    normalizationContext: ["groups" => ["basket:read"]]
)]
#[ORM\Entity(repositoryClass: BasketRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Basket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("basket:read")]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    #[Groups("basket:read")]
    private ?int $totalPrice = null;

    #[ORM\Column(length: 20)]
    #[Groups("basket:read")]
    private ?string $status = null;

    #[ORM\Column]
    #[Groups("basket:read")]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups("basket:read")]
    private ?DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, BasketItem>
     */
    #[ORM\OneToMany(targetEntity: BasketItem::class, mappedBy: 'basket', orphanRemoval: true)]
    #[Groups("basket:read")]
    private Collection $basketItems;

    public function __construct()
    {
        $this->basketItems = new ArrayCollection();
    }

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

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, BasketItem>
     */
    public function getBasketItems(): Collection
    {
        return $this->basketItems;
    }

    public function findBasketItemByProductId(int $productId)
    {
        return $this->basketItems->filter(function (BasketItem $basketItem) use ($productId) {
            return $basketItem->getProduct()->getId() === $productId;
        })->first();
    }

    public function addBasketItem(BasketItem $basketItem): static
    {
        if (!$this->basketItems->contains($basketItem)) {
            $this->basketItems->add($basketItem);
            $basketItem->setBasket($this);
        }

        return $this;
    }

    public function removeBasketItem(BasketItem $basketItem): static
    {
        if ($this->basketItems->removeElement($basketItem)) {
            // set the owning side to null (unless already changed)
            if ($basketItem->getBasket() === $this) {
                $basketItem->setBasket(null);
            }
        }

        return $this;
    }

    #[ORM\PrePersist]
    public function setDefaults(): void
    {
        $this->setCreatedAt(new DateTimeImmutable());
    }
}
