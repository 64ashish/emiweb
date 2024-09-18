<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Models\UserLoginHistory;

class LogUserLogin
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        // Store user login data in the database
        UserLoginHistory::create([
            'user_id' => $user->id,
            'ip_address' => Request::ip(),
            'organization_id' => $user->organization_id,
            'login_at' => date('Y-m-d H:i:s'),
        ]);

        $yearAgoDate = date('Y-m-d H:i:s', strtotime('-1 year'));
        UserLoginHistory::where('login_at', '<=', $yearAgoDate)->delete();
    }
}
