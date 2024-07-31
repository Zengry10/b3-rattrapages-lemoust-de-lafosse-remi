<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class RateProductRequest
{
    public function __construct(
        #[Assert\NotBlank(message: "Product ID is required")]
        public int $productId,
        #[Assert\LessThan(6)]
        #[Assert\GreaterThan(value: 0)]
        #[Assert\NotBlank(message: "Rating is required")]
        public int $rating,
        #[Assert\Length(min: 3)]
        #[Assert\NotBlank(message: "Note is required")]
        public string $note,
    ) {}
}
