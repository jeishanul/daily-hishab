<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Repositories\DepartmentRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\PersonalInfoRepository;
use App\Repositories\RolesRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Illuminate\support\Str;
use Illuminate\Http\Request;
use Keygen\Keygen;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        $staffs = EmployeeRepository::query()->orderByDesc('id')->get();
        return view('employee.index', compact('staffs'));
    }

    public function create()
    {
        $roles = RolesRepository::query()->orderByDesc('id')->get();
        $departments = DepartmentRepository::query()->orderByDesc('id')->get();
        return view('employee.create', compact('roles', 'departments'));
    }

    public function generatePassword()
    {
        $id = Keygen::numeric(6)->generate();
        return $id;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255|unique:personal_infos,phone',
            'password' => 'required|min:6',
            'role_name' => 'required|string|exists:roles,name',
            'department_id' => 'required|exists:departments,id',
        ]);

        if (Role::findByName(lcfirst($request->role_name))->permissions->isEmpty()) {
            return back()->with('error', 'Please assign role permission!');
        }
        $request['email_verified_at'] = now();
        $user = UserRepository::storeByRequest($request);
        PersonalInfoRepository::storeByRequest($request, $user);
        WalletRepository::create([
            'user_id' => $user->id,
        ]);

        EmployeeRepository::storeByRequest($request, $user);

        $user->assignRole(Str::lower($request->role_name));
        return to_route('employee.index')->with('success', 'Employee is create successfully!');
    }

    public function edit(Employee $employee)
    {
        $roles = RolesRepository::query()->whereNotIn('name', ['store'])->orderByDesc('id')->get();
        $departments = DepartmentRepository::query()->orderByDesc('id')->get();
        return view('employee.edit', compact('roles', 'employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user->id,
            'phone' => 'required|string|max:255|unique:personal_infos,phone,' . $employee->user->personalInfo->id,
            'password' => 'nullable|min:6',
            'role_name' => 'required|string|exists:roles,name',
            'department_id' => 'required|exists:departments,id',
        ]);

        if (Role::findByName(lcfirst($request->role_name))->permissions->isEmpty()) {
            return back()->with('error', 'Please assign role permission!');
        }
        UserRepository::updateByRequest($request, $employee->user);
        PersonalInfoRepository::updateByRequest($request, $employee->user->personalInfo);
        EmployeeRepository::updateByRequest($request, $employee);
        $employee->user->assignRole(Str::lower($request->role_name));
        return back()->with('success', 'Employee is update successfully!');
    }
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()->with('success', 'Employee is deleted successfully!');
    }
}
