<?php

namespace App\Repositories;

use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;
use Illuminate\support\Str;

class CurrencyRepository extends Repository
{
    public static function model()
    {
        return Currency::class;
    }

    public static function storeByRequest(CurrencyRequest $request)
    {
        return self::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'symbol' => $request->symbol,
            'code' => $request->code
        ]);
    }

    public static function updateByRequest(CurrencyRequest $request, Currency $currency)
    {
        $update = self::update($currency, [
            'created_by' => auth()->id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'symbol' => $request->symbol,
            'code' => $request->code
        ]);

        return $update;
    }
}
