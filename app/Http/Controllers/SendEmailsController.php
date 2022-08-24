<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailsController extends Controller
{
    //

    public function sendTest()
    {
        Mail::to('noreply@kortaben.work')->send(new TestMail());
        return "you have arrived to send test";
    }
}
