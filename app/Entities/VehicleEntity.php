<?php

namespace App\Entities;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class VehicleEntity extends Data
{
    public function __construct(
        #[Required, Min(1900)]
        public int $year,
        #[Required]
        public string $color,
        #[Required]
        public float $price,
        #[Required]
        public int $stocks,
        #[Required]
        public string $type,
        #[Required]
        public array $properties
    ) {
    }
}
