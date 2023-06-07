<?php

namespace App\Entities;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class SaleEntity extends Data
{
    public ?int $total_price;
    public ?string $user_id;

    public function __construct(
        #[Required]
        public string $vehicle_id,
        #[Required, Min(1)]
        public int $quantity,
    ) {
    }

    public function setTotalPrice(int $total_price): void
    {
        $this->total_price = $total_price;
    }

    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function toArray(): array
    {
        $a = parent::toArray();
        $a['total_price'] = $this->total_price;
        return $a;
    }
}
