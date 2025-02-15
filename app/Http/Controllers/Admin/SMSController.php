<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\sms\Store;
use App\Models\SMS;
use App\Traits\ReportTrait;


class SMSController extends Controller
{
    public function index()
    {
        $smss = SMS::latest()->get();
        return view('admin.sms.index', get_defined_vars());
    }
    public function change(Request $request)
    {
        $sms = SMS::findOrFail($request->id);
        $disableAll = SMS::get()->each->update(['active' => 0]);
        if ($disableAll)
            $sms->update(['active' => 1]);
        ReportTrait::addToLog('تحديث باقة رسائل');
        return response()->json();
    }

    public function update(Store $request, $id)
    {
        $sms = SMS::findOrFail($id)->update($request->validated());
        ReportTrait::addToLog('تعديل باقة رسائل');
        return response()->json();
    }
}
