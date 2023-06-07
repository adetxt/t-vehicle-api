<?php

namespace App\Http\Controllers;

use App\Interfaces\ReportService;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {
    }

    public function allVehicles()
    {
        return $this->reportService->reportAllVehicles();
    }
}
