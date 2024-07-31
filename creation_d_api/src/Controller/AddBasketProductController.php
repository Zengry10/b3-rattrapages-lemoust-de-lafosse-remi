<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\BasketItem;
use App\Entity\Product;
use App\Enum\BasketStatusEnum;
use App\Request\AddProductToBasketRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

#[AsController]
class AddBasketProductController extends AbstractController
{
    public function __invoke(
        AddProductToBasketRequest $request,
        EntityManagerInterface $entityManager
    ): Basket {
        $user = $this->getUser();

        $product = $entityManager->getRepository(Product::class)->find($request->productId);

        if ($product === null) {
            throw new NotFoundHttpException(sprintf("Product with ID %s not found", $request->productId));
        }

        if ($request->quantity > $product->getUnitsRemaining()) {
            throw new UnprocessableEntityHttpException(sprintf(
                "Product '%s' has only %s units left. You are requesting for %s",
                $product->getName(),
                $product->getUnitsRemaining(),
                $request->quantity
            ));
        }

        $activeBasket = $entityManager->getRepository(Basket::class)->getUserActiveBasket($user->getId());

        if ($activeBasket === null) {
            $activeBasket = (new Basket())
                ->setUser($user)
                ->setStatus(BasketStatusEnum::DRAFT->value)
                ->setTotalPrice(0)
            ;
        }

        $basketItem = $activeBasket->findBasketItemByProductId($product->getId());

        if (!$basketItem) {
            $basketItem = (new BasketItem())
                ->setBasket($activeBasket)
                ->setProduct($product)
                ->setQuantity(0)
                ->setUnitPrice($product->getPrice())
                ->setTotalPrice(0)
            ;
        }

        $basketItemQuantity = $basketItem->getQuantity() + $request->quantity;
        $totalPrice = $basketItem->getUnitPrice() * $basketItemQuantity;
        $basketTotalPrice = $activeBasket->getTotalPrice() + $totalPrice;

        $basketItem->setQuantity($basketItemQuantity);
        $basketItem->setTotalPrice($totalPrice);

        $activeBasket->addBasketItem($basketItem);
        $activeBasket->setTotalPrice($basketTotalPrice);

        $entityManager->persist($basketItem);
        $entityManager->persist($activeBasket);

        $entityManager->flush();

        return $activeBasket;
    }
}
