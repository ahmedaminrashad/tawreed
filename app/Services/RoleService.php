<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleService
{
    // list all Roles function
    public function list()
    {
        $roles = Role::all();
        return $roles;
    }

    // Select list all Roles function
    public function listForSelect()
    {
        $roles = Role::pluck('name', 'id')->toArray();

        return $roles;
    }

    // list all Roles function AJAX
    public function listAjax()
    {
        $data = Role::select('*');
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Store new Role
    public function create($data)
    {
        DB::beginTransaction();

        $role = new Role();

        $role->name = $data['name'];

        $role->save();

        $role->syncPermissions($data['permissions']);

        DB::commit();

        return $role;
    }

    // Update Role
    public function update(Role $role, $data)
    {
        DB::beginTransaction();

        $role->update([
            'name' => $data['name']
        ]);

        $role->syncPermissions($data['permissions']);

        DB::commit();

        return $role;
    }
}
