<?php

namespace App\Repositories;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;

class DepartmentRepository extends Repository
{
    public static function model()
    {
        return Department::class;
    }

    public static function storeByRequest(DepartmentRequest $request)
    {
        $create = self::create([
            'name' => $request->name
        ]);

        return $create;
    }

    public static function updateByRequest(DepartmentRequest $request, Department $department): Department
    {
        self::update($department, [
            'name' => $request->name
        ]);

        return $department;
    }
}
