<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Traits\UploadImgTrait;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
