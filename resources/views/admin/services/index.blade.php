@extends('components.table', [
    'pageTitle' => __('admin.services'),
    'title' => __('admin.services_page'),
    'createRoute' => route('admin.services.create'),
    'createText' => __('admin.create_service'),
    'deleteText' => __('admin.delete_selected'),
    'showDeleteButton' => true,
    'dataRoute' => route('admin.services.deleteSelected'),
    'headers' => [__('admin.title'), __('admin.description'), __('admin.icon'), __('admin.actions')],
    'items' => $services->map(function ($service) {
        return [
            'id' => $service->id,
            'title' => $service->title,
            'description' => Str::limit($service->description, 15),
            'icon' => $service->icon,
        ];
    }),
    'actions' => [
        'show' => 'admin.services.show',
        'edit' => 'admin.services.edit',
        'delete' => 'admin.services.delete',
    ],
])
