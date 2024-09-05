<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\User;
use App\Repositories\PersonalInfoRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = UserRepository::query()->role('supplier')->orderByDesc('id')->get();
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(SupplierRequest $request)
    {
        $user = UserRepository::storeByRequest($request);
        PersonalInfoRepository::storeByRequest($request, $user);
        $user->assignRole('supplier');
        return to_route('supplier.index')->with('success', 'Supplier is created successfully!');
    }

    public function edit(User $user)
    {
        return view('supplier.edit', compact('user'));
    }

    public function update(SupplierRequest $request, User $user)
    {
        UserRepository::updateByRequest($request, $user);
        PersonalInfoRepository::updateByRequest($request, $user->personalInfo);
        return to_route('supplier.index')->with('success', 'Supplier is update successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Supplier is deleted successfully!');
    }

    public function downloadSupplierSample()
    {
        return response()->download(public_path('import/sample_supplier.csv'));
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
                    PersonalInfoRepository::create([
                        'name' => $row[0],
                        'company_name' => $row[1],
                        'vat_number' => $row[2],
                        'email' => $row[3],
                        'phone_number' => $row[4],
                        'address' => $row[5],
                        'city' => $row[6],
                        'state' => $row[7],
                        'postal_code' => $row[8],
                        'country' => $row[9],
                    ]);
                }
            }
            return back()->with('success', 'Supplier import successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Please provide valid data in the csv file!');
        }
    }
}
