<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        return $this->json('Settings', [
            'currency_position' => getSettings('currency_position') ?? 'Prefix',
            'symbol' => getSettings('currency_symbol') ?? '$'
        ]);

    }
}
