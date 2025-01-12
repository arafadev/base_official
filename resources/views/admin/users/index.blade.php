@extends('components.table', [
    'pageTitle' => __('admin.users'),
    'title' => __('admin.users_page'),
    'createRoute' => route('admin.users.create'),
    'createText' => __('admin.create_user'),
    'deleteText' => __('admin.delete_selected'),
    'showDeleteButton' => true,
    'dataRoute' => route('admin.users.deleteSelected'),
    'headers' => [ __('admin.image'), __('admin.name'), __('admin.email'), __('admin.phone'), __('admin.is_active'), __('admin.is_blocked'), __('admin.is_notify'), __('admin.created_at'), __('admin.actions')],
    'items' => $users->map(function ($user) {
        return [
            'id' => $user->id,
            'image' => $user->avatar,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->full_phone,
            'is_active' => $user->active_icon,
            'is_blocked' => $user->blocked_icon,
            'is_notify' => $user->notify_icon,
            'created_at' => $user->created_at->diffForHumans(),
        ];
    }),
    'actions' => [
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'delete' => 'admin.users.delete',
    ],
])
