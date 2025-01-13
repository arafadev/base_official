<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\Admin\UpdateAdminRequest;
use Spatie\Permission\Models\Role;

class AdminController extends Controller

{   public function index()
    {
        return view('admin.admins.index' , ['admins' => Admin::with('role')->get()]);
    }

    public function create(){
        $roles = Role::get();
        $countries = Country::get();
        return view('admin.admins.create', get_defined_vars());
    }

    public function store(StoreAdminRequest  $request)
    {
        $data = $request->validated();
        $role_name = Role::findOrFail($data['role_id'])->name;
        $admin = Admin::create($data);
        $admin->assignRole($role_name); 
        return redirect()->route('admin.admins.index')->with('success', __('admin.progress_success'));
    }

    public function edit($id)
    {
       $admin =  Admin::findOrFail($id);
       $countries = Country::get();
       $roles = Role::get();
        return view('admin.admins.edit'  ,get_defined_vars());
    }

    public function show($id){
       $countries = Country::get();
       $admin = Admin::findOrFail($id);
        return view('admin.admins.show', get_defined_vars());
    }


    public function update(UpdateAdminRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $data = $request->validated();
    
        $admin->update($data);
    
        $role_name = Role::findOrFail($data['role_id'])->name;
        $admin->syncRoles([$role_name]); 
    
        return redirect()->route('admin.admins.index')->with('success', __('admin.progress_success'));
    }
    
    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        Admin::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
