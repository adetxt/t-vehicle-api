<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface ReportService
{
    public function reportAllVehicles(): Collection;
}
