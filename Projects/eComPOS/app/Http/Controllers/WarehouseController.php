<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseRequest;
use App\Models\Warehouse;
use App\Repositories\WarehouseRepository;

class WarehouseController extends Controller
{

    public function index()
    {
        $warehouses = WarehouseRepository::query()->orderByDesc('id')->get();
        return view('warehouse.index', compact('warehouses'));
    }

    public function store(WarehouseRequest $request)
    {
        WarehouseRepository::storeByRequest($request);
        return back()->with('success', 'Warehouse is created successfully!');
    }

    public function update(WarehouseRequest $request, Warehouse $warehouse)
    {
        WarehouseRepository::updateByRequest($request, $warehouse);
        return back()->with('success', 'Warehouse is updated successfully');
    }

    public function delete(Warehouse $warehouse)
    {
        $warehouse->delete();
        return back()->with('success', 'Warehouse is deleted successfully');
    }
}
