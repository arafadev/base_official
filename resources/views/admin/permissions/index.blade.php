@extends('components.table', [
    'pageTitle' => __('admin.permissions'),
    'title' => __('admin.permissions_page'),
    'createRoute' => route('admin.permissions.create'),
    'createText' => __('admin.create_permission'),
    'deleteText' => __('admin.delete_selected'),
    'showDeleteButton' => true,
    'dataRoute' => route('admin.permissions.deleteSelected'),
    'headers' => [__('admin.name'),__('admin.actions')],
    'items' => $permissions->map(function ($permission) {
        return [
            'id' => $permission->id,
            'name' => $permission->name,
        ];
    }),
    'actions' => [
        // 'show' => 'admin.permissions.show',
        // 'edit' => 'admin.permissions.edit',
        // 'delete' => 'admin.permissions.delete',
    ],
])
    