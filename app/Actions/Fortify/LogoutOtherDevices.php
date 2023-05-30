<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Auth;

class LogoutOtherDevices
{

    public function handle($request, $next)
    {
        // logout other devices
        if(!is_null(Auth::user()))
        {
            $ipAddress =  explode(',', Auth::user()->organization->ip_address??null);
            if(Auth::user() && Auth::user()->hasRole('organizational subscriber') && is_array($ipAddress))
            {
                Auth::logoutOtherDevices($request->password);
            }
        }
        return $next($request);
    }

}