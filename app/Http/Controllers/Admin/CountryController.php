<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
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
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('admin/upload/countries'), $imageName);
            $data['image'] = $imageName;
        }
    
        Country::create($data);
    
        return redirect()->route('admin.countries.index');
    }


    public function edit($id)
    {
        return view('admin.countries.edit' , ['country' => Country::findOrFail($id)]);
    }

    public function update(UpdateCountryRequest $request, $country_id)
    {

        dd($request->all());
        $country = Country::findOrFail($country_id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete the old image
            $originalImage = $country->image;
            if ($originalImage) {
                $filePath = public_path('admin/upload/countries/' . $originalImage);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Upload the new image
            $image = $request->file('image');
            $imageName = rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('admin/upload/countries'), $imageName);
            $data['image'] = $imageName;
        }

        $country->update($data);

        return redirect()->route('admin.countries.index');
    }
    
    
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
    
        $originalImage = $country->image;
    
        if ($originalImage) {
            $filePath = public_path('admin/upload/countries/' . $originalImage);
    
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    
        $country->delete();
    
        return redirect()->route('admin.countries.index');
    }

    

}
