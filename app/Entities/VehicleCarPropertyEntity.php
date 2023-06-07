<?php

namespace App\Entities;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class VehicleCarPropertyEntity extends Data
{
    public function __construct(
        #[Required]
        public string $engine,
        #[Required, Min(1)]
        public int $passenger_capacity,
        #[Required]
        public string $type,
    ) {
    }
}
