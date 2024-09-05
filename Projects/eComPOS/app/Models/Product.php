<?php

namespace App\Models;

use App\Enums\BarcodeSymbology;
use App\Enums\DiscountType;
use App\Enums\ProductTypes;
use App\Enums\TaxMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'discount_type' => DiscountType::class,
        'type' => ProductTypes::class,
        'barcode_symbology' => BarcodeSymbology::class,
        'tax_method' => TaxMethods::class,
    ];

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function productWarehouse()
    {
        return $this->belongsToMany(Warehouse::class, (new ProductWarehouse())->getTable())->withPivot('product_id', 'price', 'qty');
    }

    public function purchaseProducts()
    {
        return $this->hasMany(ProductPurchase::class, 'product_id');
    }

    public function saleProducts()
    {
        return $this->hasMany(ProductSale::class, 'product_id');
    }

    public function saleReturnProducts()
    {
        return $this->hasMany(SaleReturnProduct::class, 'product_id');
    }

    public function scopeActiveStandard($query)
    {
        return $query->where([
            ['type', 'standard']
        ]);
    }

    public function scopeActiveFeatured($query)
    {
        return $query->where([
            ['is_featured', 1]
        ]);
    }
}
