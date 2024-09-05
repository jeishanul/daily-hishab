<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductWarehouse extends Model
{
    protected $guarded = ['id'];

    public function warehouseProduct(){
        return $this->belongsTo(Product::class);;
    }
    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }
}
