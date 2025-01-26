@extends('components.table', [
    'pageTitle' => __('admin.reports'),
    'title' => __('admin.reports_page'),
    // 'createRoute' => route('admin.reports.create'),
    // 'createText' => __('admin.create_report'),
    'deleteText' => __('admin.delete_selected'),
    'showDeleteButton' => true,
    'dataRoute' => route('admin.reports.deleteSelected'),
    'headers' => [__('admin.title'), __('admin.admin_name') , __('admin.url'), __('admin.method'), __('admin.ip'), __('admin.agent'), __('admin.created_at'), __('admin.actions')],
    'items' => $reports->map(function ($report) {
        return [
            'id' => $report->id,
            'title' => $report->subject,
            'admin' => $report->admin?->name,
            'url' => Str::limit($report->url, 4),
            'method' => $report->method,
            'ip' => $report->ip,
            'agent' => $report->agent,
            'created_at' => $report->created_at,
        ];
    }),
    'actions' => [
        'delete' => 'admin.reports.delete',
    ],
])

