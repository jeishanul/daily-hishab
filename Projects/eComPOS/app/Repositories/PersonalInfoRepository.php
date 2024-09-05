<?php

namespace App\Repositories;

use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Http\Request;

class PersonalInfoRepository extends Repository
{
    public static function model()
    {
        return PersonalInfo::class;
    }
    public static function storeByRequest(Request $request, User $user)
    {
        return self::create([
            'user_id' => $user->id,
            'customer_group_id' => $request->customer_group_id,
            'company_name' => $request->company_name,
            'tax_no' => $request->tax_no,
            'phone' => $request->phone,
            'phone_verified_at' => $request->phone_verified_at,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
        ]);
    }

    public static function updateByRequest(Request $request, PersonalInfo $personalinfo)
    {
        return self::update($personalinfo, [
            'customer_group_id' => $request->customer_group_id,
            'company_name' => $request->company_name,
            'tax_no' => $request->tax_no,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
        ]);
    }

    public static function createOrUpdateByRequest(Request $request, PersonalInfo $personalinfo = null){
        $personalinfo = self::query()->updateOrCreate([
            'id' => $personalinfo?->id,
        ], [
            'user_id' => auth()->id(),
            'customer_group_id' => $request->customer_group_id,
            'company_name' => $request->company_name,
            'tax_no' => $request->tax_no,
            'phone' => $request->phone,
            'phone_verified_at' => $request->phone_verified_at,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
        ]);

        return $personalinfo;
    }
}
