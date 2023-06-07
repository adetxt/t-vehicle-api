<?php

namespace App\Entities;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class RegisterEntity extends Data
{
    public function __construct(
        #[Required]
        public string $name,
        #[Required]
        public string $email,
        #[Required]
        public string $password,
    ) {
    }
}
