@extends('components.table', [
    'pageTitle' => __('admin.admins'),
    'title' => __('admin.admins_page'),
    'createRoute' => route('admin.admins.create'),
    'createText' => __('admin.create_admin'),
    'deleteText' => __('admin.delete_selected'),
    'showDeleteButton' => true,
    'dataRoute' => route('admin.admins.deleteSelected'),
    'headers' => [ __('admin.image'), __('admin.name'), __('admin.email'), __('admin.phone'), __('admin.is_blocked'), __('admin.is_notify'), __('admin.created_at'), __('admin.actions')],
    'items' => $admins->map(function ($admin) {
        return [
            'id' => $admin->id,
            'image' => $admin->avatar,
            'name' => $admin->name,
            'email' => $admin->email,
            'phone' => $admin->full_phone,
            'is_blocked' => $admin->blocked_icon,
            'is_notify' => $admin->notify_icon,
            'created_at' => $admin->created_at->diffForHumans(),
        ];
    }),
    'actions' => [
        'show' => 'admin.admins.show',
        'edit' => 'admin.admins.edit',
        'delete' => 'admin.admins.delete',
    ],
])
