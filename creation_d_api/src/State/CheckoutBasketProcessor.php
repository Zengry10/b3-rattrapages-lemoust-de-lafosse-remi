<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Basket;
use App\Enum\BasketStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use RuntimeException;

class CheckoutBasketProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @inheritDoc
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Basket
    {
        if (!$data instanceof Basket) {
            throw new LogicException(sprintf("Expected an instance of %s", Basket::class));
        }

        foreach ($data->getBasketItems() as $basketItem) {
            if ($basketItem->getQuantity() > $basketItem->getProduct()->getUnitsRemaining()) {
                throw new RuntimeException(sprintf(
                    "Product '%s' has only %s units left. You are requesting for %s",
                    $basketItem->getProduct()->getName(),
                    $basketItem->getProduct()->getUnitsRemaining(),
                    $basketItem->getQuantity()
                ));
            }
        }

        foreach ($data->getBasketItems() as $basketItem) {
            $newProductQuantity = $basketItem->getProduct()->getUnitsRemaining() - $basketItem->getQuantity();

            $basketItem->getProduct()->setUnitsRemaining($newProductQuantity);

            $this->entityManager->flush();
        }

        $data->setStatus(BasketStatusEnum::COMPLETED->value);

        $this->entityManager->flush();

        return $data;
    }
}
