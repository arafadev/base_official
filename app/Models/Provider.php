<?php

namespace App\Models;

use App\Models\AuthBaseModel;
use App\Enums\ProviderApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Provider extends AuthBaseModel
{

    const IMAGEPATH = 'providers';

    protected $fillable =
    [
        'name',
        'email',
        'phone',
        'password',
        'country_code',
        'avatar',
        'is_active',
        'is_blocked',
        'is_approved',
        'code',
        'code_expire'
    ];

    

    public function getBlockedIconAttribute()
    {
        $url = route('admin.providers.toggle', ['id' => $this->id, 'field' => 'is_blocked']);
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
        $url = route('admin.providers.toggle', ['id' => $this->id, 'field' => 'is_active']);

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
        $url = route('admin.providers.toggle', ['id' => $this->id, 'field' => 'is_approved']);

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

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            if (isset($model->attributes['avatar'])) {
                $model->deleteFile($model->attributes['avatar'], static::IMAGEPATH);
            }
        });
    }
}
