<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\Admin\UpdateAdminRequest;
use App\Services\AdminService;
use App\Services\RoleService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        private readonly AdminService $adminService,
        private readonly RoleService $roleService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = $this->roleService->listForSelect();

        $admins = $this->adminService->list();

        if ($request->ajax()) {
            $data['columns']    = $request->columns;
            $data['order']      = $request->order[0]['column'];
            $data['orderBy']    = $data['columns'][$data['order']]["name"];
            $data['orderDir']   = $request->order[0]['dir'];
            $data['search']     = $request->search;
            $data['roleID']     = $data['columns'][2]["search"]["value"];

            return $this->adminService->listAjax($data);
        }

        return view('admin.admins.index', compact('admins', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Create Admin User';

        $pageAction = 'Create';

        $formTitle = 'Create Admin User';

        $roles = $this->roleService->listForSelect();

        return view('admin.admins.create', compact('roles', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();

        $admin = $this->adminService->create($data);

        return redirect()->route('admin.admins.show', ['admin' => $admin])->with('success', 'Admin User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $pageTitle = 'Edit Admin User';

        $pageAction = 'Edit';

        $formTitle = 'Edit Admin User';

        $roles = $this->roleService->listForSelect();

        return view('admin.admins.edit', compact('admin', 'roles', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $data = $request->validated();

        $admin = $this->adminService->update($admin, $data);

        return redirect()->route('admin.admins.show', ['admin' => $admin])->with('success', 'Admin User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
