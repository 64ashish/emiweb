<?php
namespace App\Traits;

trait RoleBasedRedirect{

    private function NowRedirectTo($destinationForAdmin,$destinationForEmiweb, $message){

        // do stuff if admin
        if (auth()->user()->hasRole('super admin')) {
            return redirect($destinationForAdmin)->with('success', $message);
        }
        //        do stuff if emiweb admin and staff
        if (auth()->user()->hasRole(['emiweb admin', 'emiweb staff'])) {
            return redirect($destinationForEmiweb)->with('success', $message);

        }
    }
}
