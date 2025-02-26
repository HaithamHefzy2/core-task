<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RoleService;
use App\Traits\ApiResponse;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    use ApiResponse;

    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        $roles = $this->roleService->getAllRoles($request->get('per_page'));
        return $this->successResponse(RoleResource::collection($roles), 'Roles retrieved successfully');
    }

    // Create new role
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = $this->roleService->createRole($data);

        // Sync permissions if provided
        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $this->successResponse(new RoleResource($role), 'Role created successfully');
    }

    // Show role by ID
    public function show($id)
    {
        $role = $this->roleService->getRoleById($id);
        return $role
            ? $this->successResponse(new RoleResource($role), 'Role retrieved successfully')
            : $this->errorResponse('Role not found', 404);
    }

    // Update role data
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|unique:roles,name,' . $id,
            'permissions' => 'array'
        ]);

        $role = $this->roleService->updateRole($id, $data);
        if (! $role) {
            return $this->errorResponse('Role not found', 404);
        }

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $this->successResponse(new RoleResource($role), 'Role updated successfully');
    }

    // Delete a role
    public function destroy($id)
    {
        return $this->roleService->deleteRole($id)
            ? $this->successResponse([], 'Role deleted successfully')
            : $this->errorResponse('Role not found', 404);
    }
}
