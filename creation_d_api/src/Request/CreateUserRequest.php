<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserRequest
{
    public function __construct(
        #[Assert\NotBlank(message: "Username is required")]
        #[Assert\Length(min: 3, max: 255)]
        public string $username,
        #[Assert\NotBlank(message: "Password is required")]
        #[Assert\Length(min: 8, max: 255)]
        public string $password,
    ) {}
}
