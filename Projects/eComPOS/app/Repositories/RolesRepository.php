<?php

namespace App\Repositories;

use App\Http\Requests\RoleRequest;
use App\Models\Roles;
use Spatie\Permission\Models\Role;

class RolesRepository extends Repository
{
    public static function model()
    {
        return Roles::class;
    }

    public static function storeByRequest(RoleRequest $request)
    {
        $create = self::create([
            'name' => $request->name,
            'description' => $request->description,
            'guard_name' => 'web',
        ]);

        return $create;
    }

    public static function updateByRequest(RoleRequest $request, Role $role)
    {
        $update = self::update($role, [
            'description' => $request->description,
        ]);

        return $update;
    }
}
