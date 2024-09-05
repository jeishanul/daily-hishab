<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = 'Pending';
        if ($this->status == 1) {
            $status = 'On process';
        } elseif ($this->status == 2) {
            $status = 'Delivered';
        } elseif ($this->status == 3) {
            $status = 'Cancelled';
        }
        
        return [
            'id' => $this->id,
            'order_id' => $this->reference_no,
            'status' => $status,
            'grand_total' => $this->grand_total,
            'address' => $this->customer->personalInfo->address,
        ];
    }
}
