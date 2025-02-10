<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UploadTrait;
use App\Models\AuthBaseModel;
use App\Enums\ProviderApproved;



class User extends AuthBaseModel
{
    const IMAGEPATH = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'country_code',
        'phone',
        'avatar',
        'is_active',
        'is_blocked',
        'lang',
        'is_notify',
        'code',
        'code_expire',
    ];


    public function getBlockedIconAttribute()
    {
        $url = route('admin.users.toggle', ['id' => $this->id, 'field' => 'is_blocked']);
        if ($this->attributes['is_blocked']) {
            return '<a href="' . $url . '" style="text-decoration: none;">
                        <i class="fe fe-slash" style="color: #e74c3c; font-size: 18px;"></i>
                    </a>';
        }
        return '<a href="' . $url . '" style="text-decoration: none;">
                    <i class="fe fe-check" style="color: #2ecc71; font-size: 18px;"></i>
                </a>';
    }

    public function getActiveIconAttribute()
    {
        $url = route('admin.users.toggle', ['id' => $this->id, 'field' => 'is_active']);

        if ($this->attributes['is_active']) {
            return '<a href="' . $url . '" style="text-decoration: none;">
                    <i class="fe fe-check-circle" style="color: #2ecc71; font-size: 18px;"></i>
                </a>';
        }

        return '<a href="' . $url . '" style="text-decoration: none;">
                <i class="fe fe-x-circle" style="color: #e74c3c; font-size: 18px;"></i>
            </a>';
    }

    public function getApprovedIconAttribute()
    {
        $url = route('admin.users.toggle', ['id' => $this->id, 'field' => 'is_approved']);

        switch ($this->attributes['is_approved']) {
            case ProviderApproved::PENDING:
                return '<a href="' . $url . '" style="text-decoration: none;">
                            <i class="fe fe-clock" style="color: #f1c40f; font-size: 18px;"></i>
                        </a>';
            case ProviderApproved::ACCEPTED:
                return '<a href="' . $url . '" style="text-decoration: none;">
                            <i class="fe fe-thumbs-up" style="color: #2ecc71; font-size: 18px;"></i>
                        </a>';
            case ProviderApproved::REJECTED:
                return '<a href="' . $url . '" style="text-decoration: none;">
                            <i class="fe fe-thumbs-down" style="color: #e74c3c; font-size: 18px;"></i>
                        </a>';
            default:
                return '<a href="' . $url . '" style="text-decoration: none;">
                            <i class="fe fe-alert-triangle" style="color: #e67e22; font-size: 18px;"></i>
                        </a>';
        }
    }

    public function getNotifyIconAttribute()
    {
        $url = route('admin.users.toggle', ['id' => $this->id, 'field' => 'is_notify']);

        if ($this->attributes['is_notify']) {
            return '<a href="' . $url . '" style="text-decoration: none;">
                    <i class="fe fe-bell" style="color: #2ecc71; font-size: 18px;"></i>
                </a>';
        }

        return '<a href="' . $url . '" style="text-decoration: none;">
                <i class="fe fe-bell-off" style="color: #e74c3c; font-size: 18px;"></i>
            </a>';
    }
}
