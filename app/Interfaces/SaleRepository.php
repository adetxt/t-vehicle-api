<?php

namespace App\Interfaces;

use App\Entities\SaleEntity;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

interface SaleRepository
{
    public function getAll(): Collection;
    public function getById($id): Sale;
    public function create(SaleEntity $data): Sale;
    public function delete($id);
}
