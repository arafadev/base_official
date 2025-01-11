<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionTableSeeder extends Seeder
{
    public function run()
    {
        $sections = [
            ['name' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'fe-home', 'permission_name' => 'read.dashboard', 'parent_id' => null, 'is_dropdown' => false],
            ['name' => 'Admins', 'route' => 'admin.admins.index', 'icon' => 'fe-users', 'permission_name' => 'read.admins', 'parent_id' => null, 'is_dropdown' => false],
            ['name' => 'Providers', 'route' => 'admin.providers.index', 'icon' => 'fe-user-plus', 'permission_name' => 'read.providers', 'parent_id' => null, 'is_dropdown' => false],
            ['name' => 'Users', 'route' => 'admin.users.index', 'icon' => 'fe-user', 'permission_name' => 'read.users', 'parent_id' => null, 'is_dropdown' => false],
            ['name' => 'Countries', 'route' => 'admin.countries.index', 'icon' => 'fe-globe', 'permission_name' => 'read.countries', 'parent_id' => null, 'is_dropdown' => false],
            ['name' => 'Regions', 'route' => 'admin.regions.index', 'icon' => 'fe-map', 'permission_name' => 'read.regions', 'parent_id' => null, 'is_dropdown' => false],
            ['name' => 'Services', 'route' => 'admin.services.index', 'icon' => 'fe-briefcase', 'permission_name' => 'read.services', 'parent_id' => null, 'is_dropdown' => false],
            ['name' => 'Settings', 'route' => 'admin.site_settings.index', 'icon' => 'fe-tool', 'permission_name' => 'read.settings', 'parent_id' => null, 'is_dropdown' => false],
            ['name' => 'Reports', 'route' => 'admin.reports.index', 'icon' => 'fe-tool', 'permission_name' => 'read.reports', 'parent_id' => null, 'is_dropdown' => false],
            ['name' => 'Role & Permissions', 'route' => null, 'icon' => 'fe-box', 'permission_name' => 'read.role_permissions', 'parent_id' => null, 'is_dropdown' => true],
            ['name' => 'All Roles', 'route' => 'admin.roles.index', 'icon' => 'fe-circle', 'permission_name' => 'read.roles', 'parent_id' => 10, 'is_dropdown' => false],
            ['name' => 'Permissions', 'route' => 'admin.permissions.index', 'icon' => 'fe-check', 'permission_name' => 'read.permissions', 'parent_id' => 10, 'is_dropdown' => false],
        ];

        Section::insert($sections);
    }
}
