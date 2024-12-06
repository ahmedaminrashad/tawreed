<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // constructor
    public function __construct(
        private RoleService $roleService,
        private PermissionService $permissionService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = $this->roleService->list();

        if ($request->ajax()) {
            return $this->roleService->listAjax();
        }

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Create Role';

        $pageAction = 'Create';

        $formTitle = 'Create Role';

        $permissionsGroups = $this->permissionService->list();

        return view('admin.roles.create', compact('permissionsGroups', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $data = $request->validated();

        $role = $this->roleService->create($data);

        return redirect()->route('admin.roles.edit', ['role' => $role])->with('success', 'Role created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $pageTitle = 'Edit Role';

        $pageAction = 'Edit';

        $formTitle = 'Edit Role';

        $permissionsGroups = $this->permissionService->list();

        return view('admin.roles.edit', compact('role', 'permissionsGroups', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $data = $request->validated();

        $role = $this->roleService->update($role, $data);

        return redirect()->route('admin.roles.edit', ['role' => $role])->with('success', 'Role updated successfully');
    }
}
