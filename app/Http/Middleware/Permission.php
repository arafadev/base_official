<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permission
{
   
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::guard('admin')->user();

        if (!$user || !$user->can($permission)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
