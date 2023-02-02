<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $permissionConfigs = getPermissionConfig();

        $permissions = [];

        foreach ($permissionConfigs as $permissionConfig) {
            $modules = $permissionConfig['modules'];
            foreach ($modules as $moduleName => $module) {
                foreach ($module['actions'] as $action) {
                    // create permissions
                    $permissions[] = [
                        'name'       => "{$action}_{$moduleName}",
                        'guard_name' => 'web',
                        'module'     => $moduleName,
                        'action'     => $action,
                    ];
                }
            }
        }

        Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('model_has_permissions')->truncate();
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->truncate();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();
        Permission::insert($permissions);

        $itPermissions = [];

        foreach ($permissionConfigs as $key => $permissionConfig) {
            $modules = $permissionConfig['modules'];
            foreach ($modules as $moduleName => $module) {
                $itPermissions[$moduleName]['name'] = $moduleName;
                foreach ($module['actions'] as $action) {
                    if (isset($itPermissions[$moduleName]['actions'])) {
                        $itPermissions[$moduleName]['actions'] .= ",{$action}_{$moduleName}";
                    } else {
                        $itPermissions[$moduleName]['actions'] = "{$action}_{$moduleName}";
                    }
                }
            }
        }
        $this->givePermissionToRole('Quản trị viên (IT)', $itPermissions);
    }

    private function givePermissionToRole($roleName, $permissions)
    {
        /** @var \App\Models\Role $role */
        $role            = \App\Models\Role::whereName($roleName)->first();
        $permissionDatas = [];
        foreach ($permissions as $permission) {
            $permissionArrs = $permission;

            $actions = $permissionArrs['actions'];

            if (is_string($actions)) {
                $actions = explode(',', $actions);

                foreach ($actions as $action) {
                    $permissionDatas[] = $action;
                }
            } else {
                $name    = $permissionArrs['name'];
                foreach ($actions as $action) {
                    $permissionDatas[] = "{$action}_{$name}";
                }
            }

        }
        $role->givePermissionTo($permissionDatas);
    }
}
