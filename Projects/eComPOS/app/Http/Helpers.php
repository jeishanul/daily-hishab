<?php

use App\Repositories\SettingsRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

function dateFormat($date)
{
    $format = getSettings('date_format');
    $date = Carbon::parse($date)->format($format ?? 'd-m-Y');

    if (getSettings('date_with_time') == 'Enable') {
        $date = Carbon::parse($date)->format($format . ' h:m:s');
    }
    return $date;
}

function numberFormat($number)
{
    $currencyPosition = getSettings('currency_position');
    $symbol = getSettings('currency_symbol');

    if ($currencyPosition == "Prefix") {

        return $symbol . ' ' . number_format($number, 2);
    }

    return number_format($number, 2) . ' ' . $symbol;
}

function getSettings($key)
{
    return settings()->where('key', $key)->first()?->value;
}
function settings()
{
    try {
        return Cache::remember('settings', 60 * 24 * 7, function () {
            return SettingsRepository::query()->get();
        });
    } catch (\Exception $e) {
        return Cache::remember('settings', 60 * 24 * 7, function () {
            return SettingsRepository::query()->get();
        });
    }
}
