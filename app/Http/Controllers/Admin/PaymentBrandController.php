<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentBrand\Store;
use App\Http\Requests\Admin\PaymentBrand\Update;
use App\Models\PaymentBrand ;
use App\Traits\ReportTrait;


class PaymentBrandController extends Controller
{
    public function index()
    {
        $payment_brands = PaymentBrand::get();
        
        return view('admin.payment_brands.index' , get_defined_vars());
    }

    public function create()
    {
        return view('admin.payment_brands.create');
    }


    public function store(Store $request)
    {
        PaymentBrand::create($request->validated());
        ReportTrait::addToLog('  اضافه براند') ;
        return response()->json(['url' => route('admin.paymentBrands.index')]);
    }

    public function edit($id)
    {
        $paymentbrand = PaymentBrand::findOrFail($id);
        return view('admin.paymentbrands.edit' , ['paymentbrand' => $paymentbrand]);
    }

    public function update(Update $request, $id)
    {
        PaymentBrand::findOrFail($id)->update($request->validated());
        ReportTrait::addToLog('  تعديل براند') ;
        return response()->json(['url' => route('admin.paymentBrands.index')]);
    }

    public function show($id)
    {
        $paymentbrand = PaymentBrand::findOrFail($id);
        return view('admin.paymentbrands.show' , ['paymentbrand' => $paymentbrand]);
    }
    public function destroy($id)
    {
        PaymentBrand::findOrFail($id)->delete();
        ReportTrait::addToLog('  حذف براند') ;
        return response()->json(['id' =>$id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (PaymentBrand::WhereIn('id',$ids)->get()->each->delete()) {
            ReportTrait::addToLog('  حذف العديد من براندات الدفع') ;
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
