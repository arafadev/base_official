<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\UpdateAdminRequest;

class AdminProfileController extends Controller
{
    
    public function index()
    {
        $roles = Role::latest()->get();
        $countries = Country::latest()->get();
        return view('admin.admins.profile',get_defined_vars());
    }

    public function update(UpdateAdminRequest $request)
    {
    }
}
