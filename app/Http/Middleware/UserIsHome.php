<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserIsHome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {


        $user = Auth::user();
        if(!empty($user))
        {

            $ipAddress =  explode(',', Auth::user()->organization->ip_address??null);

            if(Auth::user() && $user->hasRole('organizational subscriber') && is_array($ipAddress))
            {
                if(!in_array($request->getClientIp(), $ipAddress))
                {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect('/login')->with('error', 'Your current IP address is not allowed to access this account');
                }
            }
        }

        return $next($request);
    }
}
