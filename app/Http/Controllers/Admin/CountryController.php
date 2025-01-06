<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\StoreCountryRequest;
use App\Http\Requests\Admin\Country\UpdateCountryRequest;

class CountryController extends Controller

{   public function index()
    {
        return view('admin.countries.index' , ['countries' => Country::get()]);
    }

    public function create(){
        
        return view('admin.countries.create');
    }

    public function store(StoreCountryRequest  $request)
    {
        $data = $request->validated();
        Country::create($data);
        return redirect()->route('admin.countries.index')->with('success', __('admin.progress_success'));
    }

    public function edit($id)
    {
        return view('admin.countries.edit' , ['country' => Country::findOrFail($id)]);
    }

    public function update(UpdateCountryRequest $request, $id){
        $data = $request->validated();
        $country = Country::findOrFail($id);
        $country->update($data);
        return redirect()->route('admin.countries.index')->with('success', __('admin.progress_success'));
    }
    
    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        Country::whereIn('id', $ids)->get();
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
