<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;

class SyncCRUD extends Command
{
    protected $signature = 'sync:crud';
    protected $description = 'Sync CRUD registry';

    protected $defaultPermissions = ['index', 'show', 'create', 'store', 'update', 'delete', 'deleteSelected'];

    public function handle()
    {
        // هنا بيتأكد ان الادمن رقم 1 موجود ولا لا 
        $admin = Admin::find(1);
        if (!$admin) {
            $this->error("Admin with ID 1 not found.");
            return;
        }

        //لو موجوده هيرجعها لو مش موجوده هيروح يكريتها  SuperAdmin اسمها role هنا بيتأكد ان فيه 
        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'admin']);

        //هيروح يديهاله SuperAdmin ال role  الادمن دا لو ملهوش 
        if (!$admin->hasRole($superAdminRole->name)) {
            $admin->assignRole($superAdminRole->name);
        }

       // او السكاشن ال عندي فالمشروع CRUDs هنا بيجيب كل ال 
        $crudRegistry = config('crud_registry');

        foreach ($crudRegistry as $crud) { 
          
            if (isset($crud['has_permission']) && $crud['has_permission'] == false) {  // crud_registry.phpهنا السكشن لو ملهوش صلاحيه اصلا هيتخطاه (ملحوظه :- انت ال بتحدد اذا كان السكشن دا هيبقي ليه صلاحيه ولا لا عن طريق ملف ال
                $this->info("Skipping '{$crud['name']}' as it doesn't require permissions.");
                continue;
            }

            foreach ($this->defaultPermissions as $action) { 
                $permissionName = $crud['base_permission'] . '.' . $action; // ex:- countries.index | regions.index ..etc

               // بيرجع الصلاحيه لو مش موجوده بيكريتها 
                $permission = Permission::firstOrCreate([
                    'name' => $permissionName,
                    'group_name' => isset($crud['group_name']) ? $crud['group_name'] : $crud['base_permission'], //  مش من ضمن البكدج بس انا ضايفه عشان بيساعدني ف عرض جميع الصلاحيات فالتصميم group_nameال
                    'guard_name' => 'admin',  
                ]);

                // ربط الصلاحية بدور SuperAdmin
                if (!$superAdminRole->hasPermissionTo($permission)) {
                    $superAdminRole->givePermissionTo($permission);
                }

       
                if (!$admin->hasPermissionTo($permission)) {
                    $admin->givePermissionTo($permission);
                }
            }

            $this->info("Permissions for '{$crud['name']}' synced successfully.");
        }

        $this->info("All CRUDs and permissions synced successfully.");
    }
}
