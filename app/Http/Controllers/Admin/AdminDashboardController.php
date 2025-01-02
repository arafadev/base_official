<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
  public function index()
  {
    return view('admin.index');
  }
}
