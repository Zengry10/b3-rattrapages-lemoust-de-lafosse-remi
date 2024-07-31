<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class AddProductToBasketRequest
{
    public function __construct(
        #[Assert\NotBlank(message: "Product ID is required")]
        public int $productId,
        #[Assert\GreaterThan(value: 0)]
        #[Assert\NotBlank(message: "Quantity is required")]
        public int $quantity,
    ) {}
}