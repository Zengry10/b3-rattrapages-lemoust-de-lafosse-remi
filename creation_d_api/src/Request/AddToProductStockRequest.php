<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class AddToProductStockRequest
{
    public function __construct(
        #[Assert\GreaterThan(value: 0)]
        #[Assert\NotBlank(message: "Units is required")]
        public int $units
    ) {}
}