<?php

namespace App\Entities;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class AuthEntity extends Data
{
    public function __construct(
        #[Required]
        public string $email,
        #[Required]
        public string $password,
    ) {
    }
}
