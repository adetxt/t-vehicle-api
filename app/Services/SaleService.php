<?php

namespace App\Services;

use App\Entities\SaleEntity;
use App\Interfaces\SaleRepository;
use App\Interfaces\SaleService as SaleServiceInterface;
use App\Interfaces\VehicleService;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

class SaleService implements SaleServiceInterface
{
    public function __construct(
        protected SaleRepository $saleRepository,
        protected VehicleService $vehicleService
    ) {
    }

    public function getAll(): Collection
    {
        return $this->saleRepository->getAll();
    }

    public function getById($id): Sale
    {
        return $this->saleRepository->getById($id);
    }

    public function create(SaleEntity $data): Sale
    {
        $vehicle = $this->vehicleService->getVehicleByID($data->vehicle_id);
        if ($vehicle->stock < $data->quantity) {
            throw new \Exception('Vehicle is out of stock');
        }

        $data->setTotalPrice($vehicle->price * $data->quantity);

        $sale = $this->saleRepository->create($data);

        return $sale;
    }


    public function delete($id)
    {
        $this->saleRepository->delete($id);
    }
}
