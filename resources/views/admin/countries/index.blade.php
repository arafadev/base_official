@extends('components.table', [
    'pageTitle' => __('admin.countries'),
    'title' => __('admin.countries_page'),
    'createRoute' => route('admin.countries.create'),
    'createText' => __('admin.create_country'),
    'deleteText' => __('admin.delete_selected'),
    'showDeleteButton' => true,
    'dataRoute' => route('admin.countries.deleteSelected'),
    'headers' => [__('admin.image'),__('admin.country_name'), __('admin.country_code'), __('admin.iso2'), __('admin.iso3'),__('admin.actions')],
    'items' => $countries->map(function ($country) {
        return [
            'id' => $country->id,
            'image' => $country->image,
            'name' => $country->name,
            'country_code' => $country->country_code,
            'iso2' => $country->iso2,
            'iso3' => $country->iso3,
        ];
    }),
    'actions' => [
        'show' => 'admin.countries.show',
        'edit' => 'admin.countries.edit',
        'delete' => 'admin.countries.delete',
    ],
])
