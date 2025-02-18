<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Country;

class UserService
{
    public function getAllUsers()
    {
        return User::latest()->get();
    }

    public function getAllCountries()
    {
        return Country::all();
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function updateUser($id, array $data)
    {
        $user = $this->getUserById($id);
        $user->update($data);
        return $user;
    }

    public function toggleField(User $user, string $field)
    {
        switch ($field) {
            case 'is_blocked':
                $user->is_blocked = !$user->is_blocked;
                break;
            case 'is_notify':
                $user->is_notify = !$user->is_notify;
                break;
            case 'is_approved':
                $user->is_approved = !$user->is_approved;
                break;
            case 'is_active':
                $user->is_active = !$user->is_active;
                break;
        }

        $user->save();
        return $user;
    }

    public function deleteUsers($ids)
    {
        $users = User::whereIn('id', $ids)->get();

        foreach ($users as $user) {
            if ($user->avatar) {
                $filePath = storage_path('app/public/' . str_replace(url('/storage/'), '', $user->avatar));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        User::whereIn('id', $ids)->delete();
    }
}