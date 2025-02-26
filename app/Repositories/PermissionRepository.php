<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionRepository
{
    public function getAll($perPage)
    {
        return $perPage ? Permission::paginate($perPage) : Permission::all();
    }

    public function findById($id)
    {
        return Permission::find($id);
    }

    public function create(array $data)
    {
        return Permission::create($data);
    }

    public function update($id, array $data)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->update($data);
            return $permission;
        }
        return null;
    }

    public function delete($id)
    {
        $permission = Permission::find($id);
        return $permission ? $permission->delete() : false;
    }
}
