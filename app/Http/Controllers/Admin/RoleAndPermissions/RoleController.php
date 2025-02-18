<?php

namespace App\Http\Controllers\Admin\RoleAndPermissions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Http\Requests\Admin\Role\StoreRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use App\Http\Requests\Admin\Role\StoreRoleHasPermissionRequest;

class RoleController extends Controller
{
  public function index()
  {
    $roles = Role::all();
    return view('admin.roles.index', get_defined_vars());
  }
  public function create(){
    return view('admin.roles.create');
  }

  public function store(StoreRoleRequest $request){
    $data = $request->validated();
    Role::create($data);
    return to_route('admin.roles.index')->with('success', __('admin.progress_success'));
  }

  public function edit($id){
    $role = Role::findOrFail($id);
    return view('admin.roles.edit', get_defined_vars());
  }

  public function update(UpdateRoleRequest $request, $id){
    $role = Role::findOrFail($id);
    $data = $request->validated();
    $role->update($data);
    return to_route('admin.roles.index')->with('success', __('admin.progress_success'));
  }

  public function createRoleHasPermission()
  {
      $roles = Role::get();
      $permissions = Permission::all()->groupBy('group_name');
      return view('admin.roles.roles_has_permission_create', compact('roles', 'permissions'));
  }

  public function storeRoleHasPermission(Request $request)
{
    $data = [];
    $permissions = $request->permissions;

    if ($permissions) {

      // إضافة البيانات إلى role_has_permissions
      foreach ($permissions as $permissionId) {
          $data[] = [
              'role_id' => $request->role_id,
              'permission_id' => $permissionId,
          ];
      }
      
      // تخزين البيانات في role_has_permissions
      DB::table('role_has_permissions')->insertOrIgnore($data);

      // إضافة الصلاحيات أيضًا إلى model_has_permissions
      foreach ($permissions as $permissionId) {
          $modelData[] = [
              'model_id' => auth('admin')->id(),
              'model_type' => get_class(auth('admin')->user()),
              'permission_id' => $permissionId,
          ];
      }

      // تخزين البيانات في model_has_permissions
      DB::table('model_has_permissions')->insertOrIgnore($modelData);

           // مسح الكاش بعد التحديث
           app(PermissionRegistrar::class)->forgetCachedPermissions();

      return redirect()->back()->with('success', __('admin.progress_success'));
  }

    return to_route('admin.role.show_roles_has_permission.show')->with('error', __('admin.no_permissions_selected'));
}

public function show_roles_has_permission(){
  $roles = Role::get();
  return view('admin.roles.show_roles_has_permission', compact('roles'));
}

public function edit_roles_has_permission($role_id){
  $role = Role::findOrFail($role_id);
  $roles = Role::get();
  $permissions = Permission::all()->groupBy('group_name');
  return view('admin.roles.edit_roles_has_permission', get_defined_vars());
}

public function updateRoleHasPermission(Request $request, $role_id)
{

  $role = Role::findOrFail($role_id);
  $role->permissions()->sync($request->permissions);
  app(PermissionRegistrar::class)->forgetCachedPermissions();

    return to_route('admin.role.show_roles_has_permission.show')->with('success', __('admin.progress_success'));
}


}