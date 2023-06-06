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
        return Vehicle::all();
    }

    public function getVehicleByID(string $id): Vehicle
    {
        return Vehicle::find($id);
    }

    public function store(VehicleEntity $data)
    {
        Vehicle::create($data->all());
    }

    public function update(VehicleEntity $data, string $id)
    {
        Vehicle::where('_id', $id)->update($data->all());
    }

    public function destroy(string $id)
    {
        Vehicle::where('_id', $id)->delete();
    }
}
