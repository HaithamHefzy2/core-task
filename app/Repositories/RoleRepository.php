<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepository
{
    public function getAll($perPage = null)
    {
        return $perPage ? Role::paginate($perPage) : Role::all();
    }

    public function create(array $data)
    {
        $data['guard_name'] = 'web';
        return Role::create($data);
    }

    public function findById($id)
    {
        return Role::find($id);
    }

    public function update($id, array $data)
    {
        $role = Role::find($id);
        if ($role) {
            $role->update($data);
            return $role;
        }
        return null;
    }

    public function delete($id)
    {
        $role = Role::find($id);
        return $role ? $role->delete() : false;
    }
}
