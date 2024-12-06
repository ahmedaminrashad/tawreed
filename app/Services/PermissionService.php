<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    // list all Permissions function
    public function list()
    {
        $permissions = Permission::select('id', 'name')->orderBy('name')->pluck('name', 'id')->toArray();

        $permissionsGroups = self::permissionsGroups($permissions);

        return $permissionsGroups;
    }

    private static function permissionsGroups($permissions)
    {
        $permissionsGroups = [];
        foreach ($permissions as $id => $name) {
            $friendly_name = ucwords(str_replace('-', ' ', $name));
            $sections = explode(' ', $friendly_name);
            $group_name = end($sections);
            // $permissionsGroups[$group_name][$id] = $friendly_name;
            $permissionsGroups[$group_name][$name] = $friendly_name;
        }

        return $permissionsGroups;
    }
}
