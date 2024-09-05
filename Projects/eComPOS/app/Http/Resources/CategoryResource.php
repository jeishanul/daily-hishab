<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'thumbnail' => $this->media?->file ?? asset('public/default/default.jpg'),
            'child_categories' => CategoryResource::collection($this->children),
            'parent_category_id' => $this->category?->id,
            'parent_category_name' => $this->category?->name,
            'parent_category_thumbnail' => $this->category?->media?->file,
            'total_products' => $this->product->count()
        ];
    }
}
