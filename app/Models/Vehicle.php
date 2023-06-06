<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Vehicle extends Model
{
    protected $collection = 'vehicles';

    protected $fillable = ["year", "color", "price", "stocks", "type", "properties"];

    protected $casts = [
        'price' => 'float',
        'stocks' => 'int',
        'year' => 'int',
        'properties' => 'array'
    ];
}
