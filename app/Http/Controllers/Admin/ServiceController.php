<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Traits\ReportTrait;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\StoreServiceRequest;
use App\Http\Requests\Admin\Service\UpdateServiceRequest;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.services.index', get_defined_vars());
    }

    public function create()
    {
        return view('admin.services.create', get_defined_vars());
    }

    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();
        Service::create($data);
		ReportTrait::addToLog('اضافه مدير');
        return to_route('admin.services.index')->with('success', __('admin.progress_success'));
    }

    
    public function show($service_id)
    {
        $service = Service::findOrFail($service_id);
        return view('admin.services.show', get_defined_vars());
    }

   
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('admin.services.edit', get_defined_vars());
    }

    public function update(UpdateServiceRequest $request, $id)
    {
        $data = $request->validated();
        $service = Service::findOrFail($id);
        $service->update($data);
		ReportTrait::addToLog('تعديل مدير');
        return to_route('admin.services.index')->with('success', __('admin.progress_success'));
    }

    public function delete($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
		ReportTrait::addToLog('  حذف خدمه');
        return to_route('admin.services.index')->with('success', __('admin.progress_success'));
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        Service::whereIn('id', $ids)->delete();
		ReportTrait::addToLog('  حذف العديد من الخدمات');
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
