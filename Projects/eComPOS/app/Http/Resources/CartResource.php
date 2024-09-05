<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->product;
        $promotionalPrice = 0;

        if ($product->promotion_price && $product->is_promotion_price == 1 && Carbon::parse($product->starting_date) <= Carbon::now() && Carbon::parse($product->ending_date) >= Carbon::now()) {
            $promotionalPrice = $product->promotion_price;
        }

        return [
            'id' => $this->id,
            'product_id' => $product->id,
            'name' => $product->name,
            'thumbnail' => $product->media?->file
                ? $product->media->file
                : asset('public/default/default.jpg'),
            'qty' => $this->qty,
            'price' => round($product->price, 2),
            'subtotal' => round($this->qty * $product->price, 2),
            'promotional_price' => round($promotionalPrice, 2),
            'in_stock' => $product->qty > 0 ? true : false,
        ];
    }
}
