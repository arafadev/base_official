@extends('components.table', [
    'pageTitle' => __('admin.roles'),
    'title' => __('admin.roles_page'),
    'createRoute' => route('admin.roles.create'),
    'createText' => __('admin.create_role'),
    'deleteText' => __('admin.delete_selected'),
    'showDeleteButton' => true,
    'dataRoute' => route('admin.roles.deleteSelected'),
    'headers' => [__('admin.name'),__('admin.actions')],
    'items' => $roles->map(function ($role) {
        return [
            'id' => $role->id,
            'name' => $role->name,
        ];
    }),
    'actions' => [
        // 'show' => 'admin.roles.show',
        'edit' => 'admin.roles.edit',
        'delete' => 'admin.roles.delete',
    ],
])
    