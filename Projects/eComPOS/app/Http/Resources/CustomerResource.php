<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'group' => $this->personalInfo?->customerGroup ? CustomerGroupResource::make($this->personalInfo->customerGroup) : null,
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->personalInfo->phone ?? '',
            'address' => $this->personalInfo->address ?? '',
            'city' => $this->personalInfo->city ?? '',
            'state' => $this->personalInfo->state ?? '',
            'country' => $this->personalInfo->country ?? '',
            'zip_code' => $this->personalInfo->zip_code ?? '',
        ];
    }
}
