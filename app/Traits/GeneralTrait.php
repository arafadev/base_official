<?php

namespace App\Traits;
use App\Models\Center;
use App\Models\Employee;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


trait GeneralTrait {

    // ^^ FIXME: This is for development only, don't use it in production
    public function isCodeCorrect($verificationCode = null, $code): bool {
        if (!$verificationCode || $code != $verificationCode->code
          // || $verificationCode->code_expire->isPast()
          //|| env('RESET_CODE') != $code
        ) {
          return false;
        }
        return true;
    }


    //!! this is for production, don't use it in development
    // public function isCodeCorrect($verificationCode ,$phone): bool  
    // {
    //     $codeExpireDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $verificationCode->code_expire);

    //     if ($codeExpireDateTime->isPast()) {
    //         return false;
    //     }

    //     User::where('phone', $phone)->update(['is_active' => true]);
    //     return true;
    // }

    public function isCodeIsExpired($user = null): bool
    {
        if (Carbon::parse($user->code_expire)->isPast() || $user->code_expire == null) {
            return false;
        }
        return true;
    }

    public function auth()
    {
        return auth()->user();
    }

    public function authGuard($guard){
        return Auth::guard($guard)->user();
    }
}
