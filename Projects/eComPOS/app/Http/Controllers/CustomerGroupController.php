<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerGroupRequest;
use Illuminate\Http\Request;
use App\Models\CustomerGroup;
use App\Repositories\CustomerGroupRepository;

class CustomerGroupController extends Controller
{
    public function index()
    {
        $customerGroups = CustomerGroupRepository::query()->orderByDesc('id')->get();
        return view('customerGroup.index', compact('customerGroups'));
    }

    public function store(CustomerGroupRequest $request)
    {
        CustomerGroupRepository::storeByRequest($request);
        return back()->with('success', 'Customer group is created successfully!');
    }

    public function update(CustomerGroupRequest $request, CustomerGroup $customerGroup)
    {
        CustomerGroupRepository::updateByRequest($request, $customerGroup);
        return back()->with('success', 'Customer group is updated successfully!');
    }

    public function delete(CustomerGroup $customerGroup)
    {
        $customerGroup->delete();
        return back()->with('success', 'Customer group is deleted successfully!');
    }
}
