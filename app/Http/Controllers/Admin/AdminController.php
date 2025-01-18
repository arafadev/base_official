<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use App\Http\Requests\Admin\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\Admin\UpdateAdminRequest;

class AdminController extends Controller
{

    public function __construct(protected AdminService $adminService) {  }

    public function index()
    {
        $admins = $this->adminService->getAllAdmins();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = $this->adminService->getRoles();
        $countries = $this->adminService->getCountries();
        return view('admin.admins.create', compact('roles', 'countries'));
    }

    public function store(StoreAdminRequest $request)
    {
        $this->adminService->storeAdmin($request);
        return redirect()->route('admin.admins.index')->with('success', __('admin.progress_success'));
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $countries = $this->adminService->getCountries();
        $roles = $this->adminService->getRoles();
        return view('admin.admins.edit', compact('admin', 'countries', 'roles'));
    }

    public function show($id)
    {
        
        $admin = Admin::findOrFail($id);
        $countries = $this->adminService->getCountries();
        return view('admin.admins.show', compact('admin', 'countries'));
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        $this->adminService->updateAdmin($request, $id);
        return redirect()->route('admin.admins.index')->with('success', __('admin.progress_success'));
    }

    public function toggle(Request $request)
    {
        $this->adminService->toggleAdminField($request->id, $request->field);
        return redirect()->back()->with('success', __('admin.progress_success'));
    }

    public function deleteSelected(Request $request)
    {
        $this->adminService->deleteAdmins($request->input('ids', []));
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
