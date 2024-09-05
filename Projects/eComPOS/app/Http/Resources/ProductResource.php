<?php

namespace App\Http\Resources;

use App\Repositories\MediaRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tax = $this->tax->rate ?? 0;
        if ($tax > 0) {
            $tax = $this->price * $this->tax->rate / 100;
        }

        $promotionalPrice = 0;

        if ($this->promotion_price && $this->is_promotion_price == 1 && Carbon::parse($this->starting_date) <= Carbon::now() && Carbon::parse($this->ending_date) >= Carbon::now()) {
            $promotionalPrice = $this->promotion_price;
        }
        $extra_images = [];
        if($this->more_images){
            $images = json_decode($this->more_images) ?? [];
            foreach ($images as $image) {
                $extra_images[] = MediaRepository::find($image)->file;
            }
        }

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'code' => $this->code,
            'qty' => 0,
            'stock' => $this->qty,
            'thumbnail' => $this->media->file ?? asset('public/default/default.jpg'),
            'ending_date' => $this->ending_date ?? 'N/A',
            'price' => round($this->price, 2),
            'cost' => round($this->cost, 2),
            'subtotal' => round($this->price + $tax, 2),
            'promotional_price' => round($promotionalPrice, 2),
            'tax' => round($tax, 2),
            'batch' => $this->is_batch ? true : false,
            'tax_rate' => $this->tax->rate ?? 0,
            'rating' => $this->rating ?? 0,
            'rating_count' => $this->rating_count ?? 0,
            'in_stock' => $this->qty > 0 ? true : false,
            'product_details' => $this->product_details,
            'more_images' => $extra_images
        ];
    }
}
