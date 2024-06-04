<?php

use Carbon\Carbon;

function dateFormat($date)
{
    return Carbon::parse($date)->format('Y-m-d');
}

function currencySymbol($amount)
{
    return number_format($amount, 2, '.', ',') . ' ' . config('app.currency_symbol');
}
