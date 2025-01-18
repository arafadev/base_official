<?php 


namespace App\Services\Admin;

use App\Models\Admin;
use App\Models\Country;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Admin\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\Admin\UpdateAdminRequest;


class AdminService
{

    public function getAllAdmins()
    {
        return Admin::with('role')->get();
    }

    public function getRoles()
    {
        return Role::get();
    }

    public function getCountries()
    {
        return Country::get();
    }

    public function storeAdmin(StoreAdminRequest $request)
    {
        $data = $request->validated();
        $role_name = Role::findOrFail($data['role_id'])->name;
        $admin = Admin::create($data);
        $admin->assignRole($role_name);

        return $admin;
    }

    public function updateAdmin(UpdateAdminRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $data = $request->validated();
        $admin->update($data);
        
        $role_name = Role::findOrFail($data['role_id'])->name;
        $admin->syncRoles([$role_name]);

        return $admin;
    }

    public function toggleAdminField($id, $field)
    {
        $admin = Admin::findOrFail($id);
        if (in_array($field, ['is_blocked', 'is_notify'])) {
            if ($field === 'is_blocked') {
                $admin->is_blocked = !$admin->is_blocked;
                $admin->is_notify = false;  
            } elseif ($field === 'is_notify') {
                $admin->is_notify = !$admin->is_notify;
            }

            $admin->save();
        }

        return $admin;
    }

    public function deleteAdmins($ids)
    {
        $admins = Admin::whereIn('id', $ids)->get();

        foreach ($admins as $admin) {
            if ($admin->avatar) {
                $filePath = storage_path('app/public/' . str_replace(url('/storage/'), '', $admin->avatar));
                if (file_exists($filePath)) {
                    unlink($filePath); 
                }
            }
        }
        Admin::whereIn('id', $ids)->delete();
    }

}