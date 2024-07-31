<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Product;
use App\Request\AddToProductStockRequest;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;

class AddToProductStockProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @inheritDoc
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Product
    {
        if (!$data instanceof AddToProductStockRequest) {
            throw new LogicException(sprintf("Expected an instance of %s", AddToProductStockRequest::class));
        }

        $product = $this->entityManager->getRepository(Product::class)->find($context["uri_variables"]["id"]);

        $totalUnits = $product->getUnitsRemaining() + $data->units;

        $product->setUnitsRemaining($totalUnits);

        $this->entityManager->flush();

        return $product;
    }
}