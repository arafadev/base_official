<?php

namespace App\Http\Controllers\Admin\Service;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\StoreServiceRequest;
use App\Http\Requests\Admin\Service\UpdateServiceRequest;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.services.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();
        Service::create($data);
        return to_route('admin.services.index')->with('success', __('admin.progress_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show($service_id)
    {
        $service = Service::findOrFail($service_id);
        return view('admin.services.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, $id)
    {
        $data = $request->validated();
        $service = Service::findOrFail($id);
        $service->update($data);
        return to_route('admin.services.index')->with('success', __('admin.progress_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return to_route('admin.services.index')->with('success', __('admin.progress_success'));
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        Service::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
