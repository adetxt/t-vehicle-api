<?php

namespace App\Entities;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class VehicleMotorcyclePropertyEntity extends Data
{
    public function __construct(
        #[Required]
        public string $engine,
        #[Required]
        public string $suspension,
        #[Required]
        public string $transmission,
    ) {
    }
}
