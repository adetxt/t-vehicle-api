<?php

namespace App\Repositories;

use App\Entities\VehicleEntity;
use App\Interfaces\VehicleRepository as VehicleRepositoryInterface;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;

class VehicleRepository implements VehicleRepositoryInterface
{
    public function getVehicles(): Collection
    {
        return Vehicle::latest()->get();
    }

    public function getVehicleByID(string $id): Vehicle
    {
        return Vehicle::findOrFail($id);
    }

    public function store(VehicleEntity $data)
    {
        Vehicle::create($data->all());
    }

    public function update(array $data, string $id)
    {
        Vehicle::where('_id', $id)->update($data);
    }

    public function destroy(string $id)
    {
        Vehicle::where('_id', $id)->delete();
    }
}
