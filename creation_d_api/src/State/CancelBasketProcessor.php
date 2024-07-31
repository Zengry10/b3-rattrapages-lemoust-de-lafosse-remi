<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Basket;
use App\Enum\BasketStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;

class CancelBasketProcessor implements ProcessorInterface
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

        $data->setStatus(BasketStatusEnum::CANCELLED->value);

        $this->entityManager->flush();

        return $data;
    }
}
