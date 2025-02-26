<?php

namespace App\Services;

use App\Repositories\PermissionRepository;

class PermissionService
{
    protected PermissionRepository $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    // Get all permissions
    public function getAllPermissions($perPage = null)
    {
        return $this->permissionRepository->getAll($perPage);
    }

    // Create new permission
    public function createPermission(array $data)
    {
        return $this->permissionRepository->create($data);
    }

    // Get permission by ID
    public function getPermissionById($id)
    {
        return $this->permissionRepository->findById($id);
    }

    // Update permission data
    public function updatePermission($id, array $data)
    {
        return $this->permissionRepository->update($id, $data);
    }

    // Delete a permission
    public function deletePermission($id)
    {
        return $this->permissionRepository->delete($id);
    }
}
