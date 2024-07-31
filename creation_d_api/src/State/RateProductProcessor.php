<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Product;
use App\Entity\ProductRating;
use App\Request\RateProductRequest;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RateProductProcessor implements ProcessorInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @inheritDoc
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ProductRating
    {
        if (!$data instanceof RateProductRequest) {
            throw new LogicException(sprintf("Expected an instance of %s. %s provided", RateProductRequest::class, gettype($data)));
        }

        $product = $this->entityManager->getRepository(Product::class)->find($data->productId);

        $rating = (new ProductRating())
            ->setUser($this->tokenStorage->getToken()->getUser())
            ->setProduct($product)
            ->setRating($data->rating)
            ->setNote($data->note)
        ;

        $this->entityManager->persist($rating);

        $this->entityManager->flush();

        return $rating;
    }
}