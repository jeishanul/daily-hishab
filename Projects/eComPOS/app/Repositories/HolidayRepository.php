<?php

namespace App\Repositories;

use App\Http\Requests\HolidayRequest;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayRepository extends Repository
{
    public static function model()
    {
        return Holiday::class;
    }
    public static function storeByRequest(HolidayRequest $request)
    {
        return self::create([
            'reason' => $request->reason,
            'from' => $request->from,
            'to' => $request->to,
        ]);
    }
    public static function updateByRequest(HolidayRequest $request, Holiday $holiday)
    {
        $update = self::update($holiday, [
            'reason' => $request->reason,
            'from' => $request->from,
            'to' => $request->to,
        ]);
        return $update;
    }
}
