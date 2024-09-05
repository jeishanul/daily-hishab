<?php

namespace App\Repositories;

use App\Http\Requests\UnitRequest;
use App\Models\Unit;

class UnitRepository extends Repository
{
    public static function model()
    {
        return Unit::class;
    }
    public static function storeByRequest(UnitRequest $request)
    {
        $create = self::create([
            'code' => $request->code,
            'name' => $request->name,
            'base_unit_id' => $request->base_unit_id,
            'operator' => $request->operator,
            'operation_value' => $request->operation_value
        ]);

        return $create;
    }

    public static function updateByRequest(UnitRequest $request, Unit $unit)
    {
        $update = self::update($unit, [
            'code' => $request->code,
            'name' => $request->name,
            'base_unit_id' => $request->base_unit_id,
            'operator' => $request->operator,
            'operation_value' => $request->operation_value,
        ]);

        return $update;
    }
}
