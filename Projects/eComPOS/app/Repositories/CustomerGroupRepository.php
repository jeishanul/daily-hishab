<?php

namespace App\Repositories;

use App\Models\CustomerGroup;
use Illuminate\Http\Request;

class CustomerGroupRepository extends Repository
{
    public static function model()
    {
        return CustomerGroup::class;
    }
    public static function storeByRequest(Request $request)
    {
        return self::create([
            'name' => $request->name,
            'percentage' => $request->percentage,
        ]);
    }

    public static function updateByRequest(Request $request, CustomerGroup $customergroup)
    {
        return self::update($customergroup, [
            'name' => $request->name,
            'percentage' => $request->percentage
        ]);
    }
}
