<?php

namespace App\Repositories;

use App\Entities\SaleEntity;
use App\Interfaces\SaleRepository as SaleRepositoryInterface;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

class SaleRepository implements SaleRepositoryInterface
{
    public function __construct(
        protected VehicleRepository $vehicleRepository
    ) {
    }

    public function getAll(): Collection
    {
        return Sale::all();
    }

    public function getById($id): Sale
    {
        return Sale::find($id);
    }

    public function create(SaleEntity $data): Sale
    {
        $sale = Sale::create($data->toArray());
        $vehicle = $this->vehicleRepository->getVehicleByID($data->vehicle_id);
        $this->vehicleRepository->update(['stock' => $vehicle->stock - $data->quantity], $data->vehicle_id);
        return $sale;
    }

    public function delete($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
    }

    public function reportAllVehicles(): SupportCollection
    {
        return Sale::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        "_id" => '$vehicle_id',
                        "total" => [
                            '$sum' => '$total_price'
                        ],
                        "quantity" => [
                            '$sum' => '$quantity'
                        ]
                    ]
                ]
            ]);
        });
    }
}
