<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [];

        $sections = [
            'country' => ['create', 'read', 'update', 'delete'],
            'region' => ['create', 'read', 'update', 'delete'],
            'user' => ['create', 'read', 'update', 'delete'],
            'provider' => ['create', 'read', 'update', 'delete'],
            'service' => ['create', 'read', 'update', 'delete'],
            'site_setting' => ['read', 'update'],
            'report' => ['delete'],
        ];

        foreach ($sections as $section => $actions) {
            foreach ($actions as $action) {
                $permissions[] = [
                    'name' => "{$action}.{$section}",
                    'group_name' => $section,
                    'guard_name' => 'admin',
                ];
            }
        }

        Permission::insert($permissions);
    }
}
