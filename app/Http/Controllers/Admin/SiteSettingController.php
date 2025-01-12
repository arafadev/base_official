<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use App\Models\Country;
use App\Models\Provider;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Region\StoreRegionRequest;
use App\Http\Requests\Admin\Region\UpdateRegionRequest;
use App\Http\Requests\Admin\SiteSetting\UpdateSiteSettingRequest;

class SiteSettingController extends Controller

{
    public function index()
    {
        $site_settings = SiteSetting::pluck('value', 'key')->toArray();
        return view('admin.site_settings.index', get_defined_vars());
    }

    public function create()
    {
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
        return view('admin.regions.edit', get_defined_vars());
    }

    public function show()
    {
        $provider = SiteSetting::pluck('value', 'key')->toArray();
        return view('admin.regions.show', get_defined_vars());
    }


    public function update(UpdateSiteSettingRequest $request)
    {
        $data = $request->validated();
        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        return redirect()->route('admin.site_settings.index')->with('success', __('admin.settings_updated_successfully'));
    }


    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        Region::whereIn('id', $ids)->get();
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
