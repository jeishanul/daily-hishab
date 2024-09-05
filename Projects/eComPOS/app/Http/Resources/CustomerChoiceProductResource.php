<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerChoiceProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->product;
        $tax = $product->tax->rate ?? 0;
        if ($tax > 0) {
            $tax = $product->price * $product->tax->rate / 100;
        }

        $promotionalPrice = 0;

        if ($product->promotion_price && $product->is_promotion_price == 1 && Carbon::parse($product->starting_date) <= Carbon::now() && Carbon::parse($product->ending_date) >= Carbon::now()) {
            $promotionalPrice = $product->promotion_price;
        }

        return [
            'id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'code' => $product->code,
            'qty' => 0,
            'stock' => $product->qty,
            'thumbnail' => $product->media->file ?? asset('public/default/default.jpg'),
            'ending_date' => $product->ending_date ?? 'N/A',
            'price' => round($product->price, 2),
            'promotional_price' => round($promotionalPrice, 2),
            'cost' => round($product->cost, 2),
            'tax' => round($tax, 2),
            'subtotal' => round($product->price  + $tax, 2),
            'batch' => $product->is_batch ? true : false,
            'tax_rate' => $product->tax->rate ?? 0,
            'rating' => $product->rating ?? 0,
            'rating_count' => $product->rating_count ?? 0,
            'in_stock' => $product->qty > 0 ? true : false
        ];
    }
}
