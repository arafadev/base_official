<?php

// crud_registry.php in config folder
return [
    [
        'name' => 'Dashboard',
        'route' => 'admin.dashboard',
        'icon' => 'fe fe-home',
        'base_permission' => 'dashboard',
        'is_dropdown' => false,
        'children' => [],
        'has_permission' => false,
        // 'group_name' => '',
    ],
    [
        'name' => 'Admins',
        'route' => 'admin.admins.index',
        'icon' => 'fe fe-users',
        'base_permission' => 'admins',
        'is_dropdown' => false,
        'has_permission' => true,
        'group_name' => 'admins',
        'children' => [],
    ],
    [
        'name' => 'Providers',
        'route' => 'admin.providers.index',
        'icon' => 'fe fe-user-plus',
        'base_permission' => 'providers',
        'is_dropdown' => false,
        'has_permission' => true,
        'group_name' => 'providers',
        'children' => [],
    ],
    [
        'name' => 'Users',
        'route' => 'admin.users.index',
        'icon' => 'fe fe-user',
        'base_permission' => 'users',
        'is_dropdown' => false,
        'has_permission' => true,
        'group_name' => 'users',
        'children' => [],
    ],
    [
        'name' => 'Countries',
        'route' => 'admin.countries.index',
        'icon' => 'fe fe-globe',
        'base_permission' => 'countries',
        'is_dropdown' => false,
        'has_permission' => true,
        'group_name' => 'countries',
    ],

    [
        'name' => 'Regions',
        'route' => 'admin.regions.index',
        'icon' => 'fe fe-globe',
        'base_permission' => 'regions',
        'is_dropdown' => false,
        'has_permission' => true,
        'group_name' => 'regions',
    ],
    [
        'name' => 'Services',
        'route' => 'admin.services.index',
        'icon' => 'fe fe-briefcase',
        'base_permission' => 'services',
        'is_dropdown' => false,
        'has_permission' => true,
        'group_name' => 'services',
        'children' => [],
    ],
    [
        'name' => 'Site Settings',
        'route' => 'admin.site_settings.index',
        'icon' => 'fe fe-tool',
        'base_permission' => 'site_settings',
        'is_dropdown' => false,
        'has_permission' => true,
        'children' => [],
    ],
    [
        'name' => 'Reports',
        'route' => 'admin.reports.index',
        'icon' => 'fe fe-bar-chart',
        'base_permission' => 'reports',
        'is_dropdown' => false,
        'has_permission' => true,
        'children' => [],
    ],
    [
        'name' => 'Role & Permissions',
        'route' => null,
        'icon' => 'fe fe-box',
        'base_permission' => 'roles_permissions',
        'is_dropdown' => true,
        'has_permission' => true,
        'children' => [
            [
                'name' => 'All Roles',
                'route' => 'admin.roles.index',
            ],
            [
                'name' => 'Roles Has Permission',
                'route' => 'admin.role.roles_has_permission.create',
            ],
            [
                'name' => 'Show Roles Has Permission',
                'route' => 'admin.role.show_roles_has_permission.show',
            ],
            [
                'name' => 'All Permissions',
                'route' => 'admin.permissions.index',
            ],
        ],
    ],

];
