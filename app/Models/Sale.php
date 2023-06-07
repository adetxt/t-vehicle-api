<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Sale extends Model
{
    protected $collection = 'sales';

    protected $fillable = ["vehicle_id", "quantity", "total_price"];

    protected $casts = [
        'quantity' => 'int',
        'total_price' => 'float'
    ];
}
