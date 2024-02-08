<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Facades\Session;

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
                    $organization = Organization::where('ip_address','LIKE','%'.$request->getClientIp().',%')->orWhere('ip_address','LIKE',$request->getClientIp())->first();
                    if(!empty($organization)){
                        if($organization->expire_date >= date('Y-m-d H:i:s') || $organization->expire_date == null){
                            $organization_id = $organization->id;
                            $user = User::role('subscriber')->first();
                            if(!empty($user)){
                                Auth::login($user);
                                Session::put('auto login', 'yes');
                            }else{
                                return redirect()->to('/login');
                            }
                        }
                    }
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
