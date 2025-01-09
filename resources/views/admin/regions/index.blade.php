@extends('components.table', [
    'pageTitle' => __('admin.regions'),
    'title' => __('admin.regions_page'),
    'createRoute' => route('admin.regions.create'),
    'createText' => __('admin.create_region'),
    'deleteText' => __('admin.delete_selected'),
    'showDeleteButton' => true,
    'dataRoute' => route('admin.regions.deleteSelected'),
    'headers' => [__('admin.region_name'),__('admin.country_name'),  __('admin.created_at'), __('admin.actions')],
    'items' => $regions->map(function ($region) {
        return [
            'id' => $region->id,
            'name' => $region->name,
            'country' => $region->country?->name,
            'created_at' => $region->created_at->diffForHumans(),
        ];
    }),
    'actions' => [
        'show' => 'admin.regions.show',
        'edit' => 'admin.regions.edit',
        'delete' => 'admin.regions.delete',
    ],
])
