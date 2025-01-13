<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;

class UserController extends Controller

{   public function index()
    {
        return view('admin.users.index' , ['users' => User::get()]);
    }

    public function create(){
        return view('admin.users.create', ['countries' => Country::get()]);
    }

    public function store(StoreUserRequest  $request)
    {
        $data = $request->validated();
        User::create($data);
        return redirect()->route('admin.users.index')->with('success', __('admin.progress_success'));
    }

    public function edit($id)
    {
       $user =  User::findOrFail($id);
       $countries = Country::get();
        return view('admin.users.edit'  ,get_defined_vars());
    }

    public function show($id){
       $countries = Country::get();
       $user = User::findOrFail($id);
        return view('admin.users.show', get_defined_vars());
    }


    public function update(UpdateUserRequest $request, $id)
    {
        $admin = User::findOrFail($id);
        $data = $request->validated();
        $admin->update($data);
        return redirect()->route('admin.users.index')->with('success', __('admin.progress_success'));
    }
    
    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        User::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
