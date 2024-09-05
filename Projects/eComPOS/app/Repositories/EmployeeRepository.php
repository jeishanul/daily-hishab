<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeRepository extends Repository
{
    public static function model()
    {
        return Employee::class;
    }
    public static function storeByRequest(Request $request, User $user)
    {
        return self::create([
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'staff_id' => $request->staff_id,
        ]);
    }

    public static function updateByRequest(Request $request, Employee $employee)
    {
        $update = self::update($employee, [
            'department_id' => $request->department_id,
            'staff_id' => $request->staff_id,
        ]);

        return $update;
    }
}
