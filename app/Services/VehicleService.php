<?php

namespace App\Services;

use App\Entities\VehicleEntity;
use App\Interfaces\VehicleRepository;
use App\Interfaces\VehicleService as VehicleServiceInterface;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;

class VehicleService implements VehicleServiceInterface
{
    public function __construct(
        protected VehicleRepository $vehicleRepo
    ) {
    }

    public function getVehicles(): Collection
    {
        return $this->vehicleRepo->getVehicles();
    }

    public function getVehicleByID(string $id): Vehicle
    {
        return $this->vehicleRepo->getVehicleByID($id);
    }

    public function store(VehicleEntity $data)
    {
        $this->vehicleRepo->store($data);
    }

    public function update(VehicleEntity $data, string $id)
    {
        $this->vehicleRepo->update($data->toArray(), $id);
    }

    public function updateStock(string $id, int $stock)
    {
        $this->vehicleRepo->update(['stock' => $stock], $id);
    }

    public function destroy(string $id)
    {
        $this->vehicleRepo->destroy($id);
    }
}
