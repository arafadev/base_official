<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {

        if (auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            if (auth('admin')->user()->is_blocked) {
                auth('admin')->logout();
                return redirect()->back()->withInput()->withErrors(['status' => __('admin.your_account_is_blocked')]);
            }

            $notification = array(
                'message' => 'Admin Login Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.dashboard')->with($notification);
        } else {
            return redirect()->back()->withInput()->withErrors(['loginError' => __('admin.invalid_email_or_password')]);
        }
    }


    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // $notification = [
        //     'msg' => 'Logout Successfully',
        //     'alert-type' => 'success'
        // ];

        return redirect('admin/login');
    }
}
