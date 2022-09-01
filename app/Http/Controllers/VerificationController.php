<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
//    use VerifiesEmails, RedirectsUsers;
    //

    protected $redirectTo = '/';
    public function __construct()
    {
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectpath())
            : view('verification.notice', [
                'pageTitle' => __('Account Verification')
            ]);
    }

    public function verify()
    {
        return "verify";
    }

    public function resend()
    {
        return "resend";
    }
}
