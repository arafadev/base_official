<?php

namespace App\Http\Controllers\Admin\RoleAndPermissions;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\Permission\StorePermissionRequest;

class PermissionController extends Controller
{
  public function index()
  {
    $permissions = Permission::all();
    return view('admin.permissions.index', get_defined_vars());
  }
  // public function create(){
  //   return view('admin.permissions.create');
  // }

  // public function store(StorePermissionRequest $request){
  //   $data = $request->validated();
  //   Permission::create($data);
  //   return redirect()->back();
  // }
}
