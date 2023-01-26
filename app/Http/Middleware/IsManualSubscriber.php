<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsManualSubscriber
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

        $user = auth()->user();
        $stripeSubscribed = $user->subscriptions()->active()->get()->count() > 0;
        $hasValidDate = !is_null($user->manual_expire) && Carbon::parse($user->manual_expire)->greaterThanOrEqualTo(Carbon::now());
        $manualSubscribed = $user->hasRole('subscriber') && $hasValidDate ;

        if($user->hasRole(['super admin','emiweb admin','emiweb staff','organization admin','organization staff']))
        {
            return $next($request);
        }

        if($stripeSubscribed or $manualSubscribed)
        {
//            dd("stripe: ".$stripeSubscribed ." manual: ".$manualSubscribed);
            return $next($request);

        }
        return redirect('/');
    }
}
