<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Provider\StoreProviderRequest;
use App\Http\Requests\Admin\Provider\UpdateProviderRequest;

class ProviderController extends Controller

{   public function index()
    {
        return view('admin.providers.index' , ['providers' => Provider::get()]);
    }

    public function create(){
        return view('admin.providers.create', ['countries' => Country::get()]);
    }

    public function store(StoreProviderRequest  $request)
    {
        $data = $request->validated();
        Provider::create($data);
        return redirect()->route('admin.providers.index')->with('success', __('admin.progress_success'));
    }

    public function edit($id)
    {
       $provider =  Provider::findOrFail($id);
       $countries = Country::get();
        return view('admin.providers.edit'  ,get_defined_vars());
    }

    public function show($id){
       $countries = Country::get();
       $provider = Provider::findOrFail($id);
        return view('admin.providers.show', get_defined_vars());
    }


    public function update(UpdateProviderRequest $request, $id)
    {
        $admin = Provider::findOrFail($id);
        $data = $request->validated();
        $admin->update($data);
        return redirect()->route('admin.providers.index')->with('success', __('admin.progress_success'));
    }
    
    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        Provider::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
