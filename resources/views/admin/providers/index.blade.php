@extends('components.table', [
    'pageTitle' => __('admin.providers'),
    'title' => __('admin.providers_page'),
    'createRoute' => route('admin.providers.create'),
    'createText' => __('admin.create_provider'),
    'deleteText' => __('admin.delete_selected'),
    'showDeleteButton' => true,
    'dataRoute' => route('admin.providers.deleteSelected'),
    'headers' => [__('admin.image'), __('admin.name'), __('admin.email'), __('admin.phone'), __('admin.is_active'), __('admin.is_approved'), __('admin.is_blocked'), __('admin.created_at'), __('admin.actions')],
    'items' => $providers->map(function ($provider) {
        return [
            'id' => $provider->id,
            'image' => $provider->avatar,
            'name' => $provider->name,
            'email' => $provider->email,
            'phone' => $provider->full_phone,
            'is_active' => $provider->active_icon,
            'is_approved' => $provider->approved_icon,
            'is_blocked' => $provider->blocked_icon,
            'created_at' => $provider->created_at->diffForHumans(),
        ];
    }),
    'actions' => [
        'show' => 'admin.providers.show',
        'edit' => 'admin.providers.edit',
        'delete' => 'admin.providers.delete',
    ],
])
