<?php
namespace App\Repositories;
use App\Models\ProductWarehouse;

class ProductWarehouseRepository extends Repository
{
    public static function model()
    {
        return ProductWarehouse::class;
    }
}
