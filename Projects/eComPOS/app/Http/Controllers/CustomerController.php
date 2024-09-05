<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\User;
use App\Repositories\CustomerGroupRepository;
use App\Repositories\PersonalInfoRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = UserRepository::query()->role('customer')->orderByDesc('id')->get();
        return view('customer.index', compact('customers'));
    }
    public function create()
    {
        $customerGroups = CustomerGroupRepository::query()->orderByDesc('id')->get();
        return view('customer.create', compact('customerGroups'));
    }
    public function store(CustomerRequest $request)
    {
        $user = UserRepository::storeByRequest($request);
        PersonalInfoRepository::storeByRequest($request, $user);
        $user->assignRole('customer');
        return to_route('customer.index')->with('success', 'Customer is created successfully!');
    }
    public function edit(User $user)
    {
        $customerGroups = CustomerGroupRepository::query()->orderByDesc('id')->get();
        return view('customer.edit', compact('user', 'customerGroups'));
    }
    public function update(CustomerRequest $request, User $user)
    {
        UserRepository::updateByRequest($request, $user);
        PersonalInfoRepository::updateByRequest($request, $user->personalInfo);
        return to_route('customer.index')->with('success', 'Customer is updated successfully!');
    }
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Customer is deleted successfully!');
    }

    public function downloadCustomerSample()
    {
        return response()->download(public_path('import/sample_customer.csv'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);
        $file = $request->file('file');
        $csvData = array_map('str_getcsv', file($file));
        try {
            foreach ($csvData as $key => $row) {
                if ($key > 0) {
                    $customerGroup = CustomerGroupRepository::query()->where('name', $row[0])->first();
                    $user = User::create([
                        'name' => $row[1],
                        'email' => $row[3],
                        'email_verified_at' => now(),
                        'password' => bcrypt($row[10]),
                    ]);
                    $user->personalInfo()->create([
                        'customer_group_id' => $customerGroup?->id,
                        'phone' => $row[4],
                        'phone_verified_at' => $row[4] ? now() : null,
                        'address' => $row[5],
                        'city' => $row[6],
                        'state' => $row[7],
                        'zip_code' => $row[8],
                        'country' => $row[9],
                    ]);
                }
            }
            return back()->with('success', 'Customer import successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Please provide valid data in the csv file!');
        }
    }
    public function search(Request $request)
    {
        $customers = UserRepository::searchByCustomer($request->search);
        return $this->json('Search Customer', [
            'customers' => CustomerResource::collection($customers),
        ]);
    }
    public function customerAdd(CustomerRequest $request)
    {
        $customer = UserRepository::storeByRequest($request);
        PersonalInfoRepository::storeByRequest($request, $customer);
        $customer->assignRole('customer');
        return $this->json('Customer successfully stored', [
            'customer' => CustomerResource::make($customer),
        ]);
    }
}
