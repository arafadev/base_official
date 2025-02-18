<?php
namespace App\Models;
use Carbon\Carbon;
use App\Traits\UploadTrait;
use App\Services\Sms\SmsService;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\Api\UserResource;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthBaseModel extends Authenticatable
{
    use Notifiable, UploadTrait, HasApiTokens, SoftDeletes, HasFactory;

    const IMAGEPATH = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        
        'is_notify'  => 'boolean',
        'is_blocked' => 'boolean',
    ];

    // public function setPhoneAttribute($value)
    // {
    //     if (!empty($value)) {
    //         $this->attributes['phone'] = fixPhone($value);
    //     }
    // }
    // public function getGuardAttribute(): string
    // {
    //     $guard = lcfirst(class_basename($this));
    //     $guard = $guard == 'user' ? 'web' : $guard;
    //     return $guard;
    // }

    // public function setCountryCodeAttribute($value)
    // {
    //     if (!empty($value)) {
            // $this->attributes['country_code'] = fixPhone($value);
    //     }
    // }

   public function getFullPhoneAttribute()
    {
        return $this->attributes['country_code'] . $this->attributes['phone'];
    }

    // public function setPasswordAttribute($value) 
    // {
    //     if ($value) {
    //         $this->attributes['password'] = bcrypt($value);
    //     }
    // }

    public function setAvatarAttribute($value)
    {
        if (!empty($value) && is_file($value)) {
            if (isset($this->attributes['avatar'])) {
                $this->deleteFile($this->attributes['avatar'], static::IMAGEPATH);
            }
            $this->attributes['avatar'] = $this->uploadAllTyps($value, static::IMAGEPATH);
        }
    }

    public function getAvatarAttribute()
    {
        if (!empty($this->attributes['avatar'])) {
            return $this->getImage($this->attributes['avatar'], static::IMAGEPATH);
        }
        return $this->defaultImage(static::IMAGEPATH);
    }



    public function markAsActive()
    {
        // $this->update(['code' => null, 'code_expire' => null, 'active' => true]);
        $this->update(['code' => null, 'code_expire' => null, 'is_active' => true]);
        return $this;
    }

    public function sendVerificationCode()
    {
        $this->update([
            'code' => $this->activationCode(),
            'code_expire' => Carbon::now()->addMinute(),
        ]);
        $this->sendCodeAtSms($this->code);
        // return new UserResource($this);
        return ['user' => $this];
    }

    private function activationCode()
    {
        return 1234; //^ at production it will be removed and replaced with a next line with SMS_VERIFICATION_CODE
		// return env('SMS_VERIFICATION_CODE' , 1234);
        // return mt_rand( 1111, 9999 );
    }

    public function sendCodeAtSms($code, $full_phone = null)
    {
        (new SmsService())->sendSms($full_phone ?? $this->full_phone, trans('apis.activeCode', ['code' => $code]));
    }

    public function devices()
    {
        return $this->morphMany(Device::class, 'morph');
    }

    public function login()
    {
        // $this->tokens()->delete();
        $this->updateDevice();
        $this->updateLang();
        $token = $this->createToken(request()->device_type)->plainTextToken;
        return $token;
    }

    public function updateLang()
    {
        if (request()->header('Lang') != null && in_array(request()->header('Lang'), languages())) {
            $this->update(['lang' => request()->header('Lang')]);
        } else {
            $this->update(['lang' => defaultLang()]);
        }
    }

    public function updateDevice()
    {
        if (request()->device_id) {
            $this->devices()->updateOrCreate([
				'device_id'   => request()->device_id,
				'device_type' => request()->device_type,
				'lang'        => request()->header('Lang') ?? defaultLang(),
			]);
        }
    }

    public function logout()
    {
        // $this->tokens()->delete();
        $this->currentAccessToken()->delete();
        if (request()->device_id) {
            $this->devices()->where(['device_id' => request()->device_id])->delete();
        }
        return true;
    }
    
    // public function logout()
    // {
    //     if ($this->is_blocked) {
    //         $this->tokens()->delete();
    //         $this->devices()->delete();
    //     } else {
    //         $this->currentAccessToken()->delete();
    //     }
    //     if (request()->device_id) {
    //         $this->devices()
    //             ->where(['device_id' => request()->device_id])
    //             ->delete();
    //     }
    //     return true;
    // }


    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }



    // public function replays()
    // {
    //     return $this->morphMany(ComplaintReplay::class, 'replayer');
    // }

    // public function transactions()
    // {
    //     return $this->morphMany(Transaction::class, 'transactionable')->latest();
    // }

    // public function settlements()
    // {
    //     return $this->morphMany(Settlement::class, 'transactionable')->latest();
    // }

    // public function wallet()
    // {
    //     return $this->morphOne(Wallet::class, 'walletable')->latest();
    // }

    /**
     * Get all of the complaints for the AuthBaseModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    // public function complaints()
    // {
    //     return $this->morphMany(Complaint::class, 'userable');
    // }
    // public function contacts()
    // {
    //     return $this->hasMany(ContactUs::class, 'userable_id', 'id');
    // }

    // public static function boot()
    // {
    //     parent::boot();
    //     /* creating, created, updating, updated, deleting, deleted, forceDeleted, restored */
    //     static::deleted(function ($model) {
    //         $model->deleteFile($model->id . '.png', static::IMAGEPATH);
    //     });

    //     static::created(function ($model) {
    //         $model->wallet()->create();
    //     });

    //     static::updating(function ($model) {
    //         $model->deleteFile($model->id . '.png', static::IMAGEPATH);
    //     });
    // }
}