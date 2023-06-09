<?php

namespace App\Interfaces;

use App\Entities\VehicleEntity;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;

interface VehicleRepository
{
    public function getVehicles(): Collection;
    public function getVehicleByID(string $id): Vehicle;
    public function store(VehicleEntity $data);
    public function update(array $data, string $id);
    public function destroy(string $id);
}
