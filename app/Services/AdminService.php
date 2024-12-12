<?php

namespace App\Services;

use App\Models\Admin;
use Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

readonly class AdminService
{
    // list all Admin Users function
    public function list()
    {
        $roles = Admin::all();
        return $roles;
    }

    // list all Admin Users function AJAX
    public function listAjax($ajaxData)
    {
        $data = Admin::select('*')->orderBy($ajaxData['orderBy'], $ajaxData['orderDir']);

        return DataTables::of($data)
            ->filter(function ($query) use ($ajaxData) {
                if ($ajaxData['search']['value']) {
                    $query->where('name', 'like', '%' . $ajaxData['search']['value'] . '%')
                        ->orWhere('email', 'like', '%' . $ajaxData['search']['value'] . '%');
                }

                if ($ajaxData['roleID']) {
                    $query->whereHas('roles', function ($query) use ($ajaxData) {
                        $query->where('roles.id', (int) $ajaxData['roleID']);
                    });
                }
            }, true)
            ->addIndexColumn()
            ->addColumn('role_name', function (Admin $admin) {
                return html_entity_decode($admin->adminRole);
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Store new Admin User
    public function create($data)
    {
        DB::beginTransaction();

        $admin = new Admin();

        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->password = bcrypt($data['password']);

        $admin->save();

        if (isset($data['image'])) {
            $admin->uploadFile('image', $data['image']);
        }

        $role = Role::find($data['role_id']);

        $admin->assignRole($role);

        DB::commit();

        return $admin;
    }

    // Update Admin User
    public function update(Admin $admin, $data)
    {
        DB::beginTransaction();

        $admin->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (isset($data['password'])) {
            $admin->update([
                'password' => bcrypt($data['password']),
            ]);
        }

        if (isset($data['image'])) {
            $admin->uploadFile('image', $data['image']);
        }

        $admin->roles()->detach();

        $role = Role::find($data['role_id']);

        $admin->assignRole($role);

        DB::commit();

        return true;
    }

    // Reset Admin Password
    public function resetPassword(Admin $admin, $data)
    {
        if (!Hash::check($data['old_password'], $admin->password)) {
            return false;
        }

        DB::beginTransaction();

        $admin->update([
            'password' => bcrypt($data['password']),
        ]);

        DB::commit();

        return true;
    }
}
