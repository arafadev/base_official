<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admins\StoreAdminRequest;
use App\Http\Requests\Admin\Admins\UpdateAdminRequest;
use App\Http\Requests\Admin\Country\StoreCountryRequest;
use App\Http\Requests\Admin\Country\UpdateCountryRequest;

class AdminController extends Controller

{   public function index()
    {
        return view('admin.admins.index' , ['admins' => Admin::get()]);
    }

    public function create(){
        return view('admin.admins.create', ['countries' => Country::get()]);
    }

    public function store(StoreAdminRequest  $request)
    {
        $data = $request->validated();
        Admin::create($data);
        return redirect()->route('admin.admins.index')->with('success', __('admin.progress_success'));
    }

    public function edit($id)
    {
       $admin =  Admin::findOrFail($id);
       $countries = Country::get();
        return view('admin.admins.edit'  ,get_defined_vars());
    }

    public function show($id){
        return ;
    }


    public function update(UpdateAdminRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $data = $request->validated();
        $admin->update($data);
        return redirect()->route('admin.admins.index')->with('success', __('admin.progress_success'));
    }
    
    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        Admin::whereIn('id', $ids)->get();
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
