<?php

namespace App\Services;

use App\Interfaces\SaleRepository;
use App\Interfaces\ReportService as ReportServiceInterface;
use Illuminate\Support\Collection;

class ReportService implements ReportServiceInterface
{
    public function __construct(
        protected SaleRepository $saleRepository,
        protected VehicleService $vehicleService,
    ) {
    }

    public function reportAllVehicles(): Collection
    {
        $sales = $this->saleRepository->reportAllVehicles();
        $vehicles = $this->vehicleService->getVehicles()->keyBy('_id');

        return $sales->map(function ($sale) use ($vehicles) {
            return [
                'total' => $sale->total_price,
                'quantity' => $sale->quantity,
                'vehicle' => $vehicles[$sale->_id],
            ];
        });
    }
}
