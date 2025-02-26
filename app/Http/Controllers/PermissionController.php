<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PermissionService;
use App\Traits\ApiResponse;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    use ApiResponse;

    protected PermissionService $permissionService;

    /**
     *
     * @param PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the permissions
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $permissions = $this->permissionService->getAllPermissions($request->get('per_page'));
        return $this->successResponse(PermissionResource::collection($permissions), 'Permissions retrieved successfully');
    }

    /**
     * Store a  permission
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);
        // Create the permission
        $permission = $this->permissionService->createPermission($data);

        return $this->successResponse(new PermissionResource($permission), 'Permission created successfully');
    }

    /**
     * Display the permission by its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        $permission = $this->permissionService->getPermissionById($id);
        // Check if permission exists
        return $permission
            ? $this->successResponse(new PermissionResource($permission), 'Permission retrieved successfully')
            : $this->errorResponse('Permission not found', 404);
    }

    /**
     * Update the  permission
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $data = $request->validate([
            'name' => 'sometimes|required|string|unique:permissions,name,' . $id,
        ]);

        $permission = $this->permissionService->updatePermission($id, $data);

        return $permission
            ? $this->successResponse(new PermissionResource($permission), 'Permission updated successfully')
            : $this->errorResponse('Permission not found', 404);
    }

    /**
     * Remove the permission
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->permissionService->deletePermission($id)
            ? $this->successResponse([], 'Permission deleted successfully')
            : $this->errorResponse('Permission not found', 404);
    }
}
