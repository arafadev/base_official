@extends('components.table', [
    'pageTitle' => __('admin.payment_brands'),
    'title' => __('admin.payment_brands'),
    'createRoute' => route('admin.payment_brands.create'),
    'createText' => __('admin.create_payment_brand'),
    'deleteText' => __('admin.delete_selected'),
    'showDeleteButton' => true,
    'dataRoute' => route('admin.payment_brands.deleteSelected'),
    'headers' => [__('admin.name'),__('admin.type'),  __('admin.created_at'), __('admin.actions')],
    'items' => $payment_brands->map(function ($payment_brand) {
        return [
            'id' => $payment_brand->id,
            'name' => $payment_brand->name,
            'type' => $payment_brand->type,
            'created_at' => $payment_brand->created_at->diffForHumans(),
        ];
    }),
    'actions' => [
        'show' => 'admin.payment_brands.show',
        'edit' => 'admin.payment_brands.edit',
        'delete' => 'admin.payment_brands.delete',
    ],
])
