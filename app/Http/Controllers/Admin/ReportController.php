<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LogActivity;

class ReportController extends Controller

{   public function index()
    {
        return view('admin.reports.index' , ['reports' =>LogActivity::latest()->get()]);
    }
    
    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        LogActivity::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
