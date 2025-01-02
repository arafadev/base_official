<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Traits\UploadImgTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Profile\UpdateAdminRequest;

class AdminProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index', ['admin' => Admin::find(auth('admin')->id())]);
    }

    public function update(UpdateAdminRequest $request)
    {
    }
}
