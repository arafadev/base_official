<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use App\Models\Country;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Region\StoreRegionRequest;
use App\Http\Requests\Admin\Region\UpdateRegionRequest;

class RegionController extends Controller

{   public function __construct()
    {
        $this->middleware('permission:regions.index')->only('index');
        $this->middleware('permission:regions.create')->only(['create', 'store']);
        $this->middleware('permission:regions.edit')->only(['edit', 'update']);
        $this->middleware('permission:regions.delete')->only('destroy, deleteSelected');
    }
  public function index()
    {
        return view('admin.regions.index' , ['regions' => Region::with('country')->get()]);
    }

    public function create(){
        $countries = Country::get();
        return view('admin.regions.create', get_defined_vars());
    }


    public function store(StoreRegionRequest  $request)
    {
        $data = $request->validated();
        Region::create($data);
        return redirect()->route('admin.regions.index')->with('success', __('admin.progress_success'));
    }

    public function edit($id)
    {
       $region =  Region::findOrFail($id);
       $countries = Country::get();
        return view('admin.regions.edit'  ,get_defined_vars());
    }

    public function show($id){
       $countries = Country::get();
       $provider = Region::findOrFail($id);
        return view('admin.regions.show', get_defined_vars());
    }


    public function update(UpdateRegionRequest $request, $id)
    {
        $admin = Region::findOrFail($id);
        $data = $request->validated();
        $admin->update($data);
        return redirect()->route('admin.regions.index')->with('success', __('admin.progress_success'));
    }
    
    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        Region::whereIn('id', $ids)->get();
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
