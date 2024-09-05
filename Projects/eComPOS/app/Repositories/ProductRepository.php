<?php

namespace App\Repositories;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\support\Str;

class ProductRepository extends Repository
{
    private static $path = '/product';

    public static function model()
    {
        return Product::class;
    }

    public static function storeByRequest(ProductRequest $request)
    {
        $media = null;
        if ($request->hasFile('image')) {
            $media = MediaRepository::storeByRequest(
                $request->image,
                self::$path,
                'Image',
            );
        }

        $moreImageIds = [];
        if ($request->more_image) {
            foreach ($request->more_image as $image) {
                $media = MediaRepository::storeByRequest(
                    $image,
                    self::$path,
                    'Image',
                );
                $moreImageIds[] = $media->id;
            }
        }

        return self::create([
            'type' => $request->type,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'code' => $request->code,
            'barcode_symbology' => $request->barcode_symbology,
            'media_id' => $media?->id,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'price' => $request->price,
            'qty' => 0,
            'alert_quantity' => $request->alert_quantity,
            'is_featured' => $request->featured ?? 0,
            'product_details' => $request->product_details,
            'purchase_unit_id' => $request->purchase_unit_id,
            'sale_unit_id' => $request->sale_unit_id,
            'cost' => $request->cost,
            'is_promotion_price' => $request->promotion ?? 0,
            'promotion_price' => $request->promotion_price,
            'starting_date' => $request->starting_date,
            'ending_date' => $request->last_date,
            'tax_id' => $request->tax_id,
            'tax_method' => $request->tax_method,
            'is_batch' => $request->is_batch ?? 0,
            'more_images' => json_encode($moreImageIds),
        ]);
    }

    public static function updateByRequest(ProductRequest $request, Product $product)
    {

        $media = null;
        if ($request->hasFile('image')) {
            $media = MediaRepository::updateOrCreateByRequest(
                $request->image,
                self::$path,
                'Image',
                $product->media
            );
        }
        $moreImageIds = json_decode($product->more_images);
        if ($request->more_image) {
            $moreImageIds = [];
            foreach ($request->more_image as $image) {
                $media = MediaRepository::storeByRequest(
                    $image,
                    self::$path,
                    'Image',
                );
                $moreImageIds[] = $media->id;
            }
        }

        return self::update($product, [
            'type' => $request->type,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'code' => $request->code,
            'barcode_symbology' => $request->barcode_symbology,
            'media_id' => $media ? $media->id : $product->media_id,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'price' => $request->price,
            'qty' => $product->qty ?? 0,
            'alert_quantity' => $request->alert_quantity,
            'is_featured' => $request->featured ?? 0,
            'product_details' => $request->product_details,
            'purchase_unit_id' => $request->purchase_unit_id,
            'sale_unit_id' => $request->sale_unit_id,
            'cost' => $request->cost,
            'is_promotion_price' => $request->promotion ?? 0,
            'promotion_price' => $request->promotion_price,
            'starting_date' => $request->starting_date,
            'ending_date' => $request->last_date,
            'tax_id' => $request->tax_id,
            'tax_method' => $request->tax_method,
            'is_batch' => $request->is_batch ?? 0,
            'more_images' => json_encode($moreImageIds),
        ]);
    }

    public static function search($search, $categoryId = null, $brandId = null)
    {
        $products = self::query()->when($categoryId, function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->when($brandId, function ($query) use ($brandId) {
            $query->where('brand_id', $brandId);
        })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'Like', "%{$search}%")
                    ->orWhere('code', 'Like', "%{$search}%");
            });

        return $products;
    }
    public static function updateQty($qty, $productId): Product
    {
        $product = self::find($productId);
        $totalQty =  $product->qty + $qty;
        $product->update([
            'qty' => $totalQty
        ]);
        return $product;
    }
}
