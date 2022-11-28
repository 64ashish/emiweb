<?php

namespace App\Http\Controllers;

use App\Mail\SendSuggestion;
use App\Mail\TestMail;
use CraigPaul\Mail\TemplatedMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailsController extends Controller
{
    //

    public function sendTest()
    {
//        Mail::to('hello@emiwebdb.kortaben.work')->send(new TestMail());
//        return "you have arrived to send test";
        $mailable = (new TemplatedMailable())
            ->identifier(29033328)
            ->include([
                "product_url" => "http://google.com",
                "product_name" => "product name",
                "name" => "ashish aryal",
                "action_url" => "http://kortaben.se",
                "login_url" => "http://kortaben.se",
                "username" => "username",
                "trial_length" => "1 months",
                "trial_start_date" => "today",
                "trial_end_date" => "next month",
                "support_email" => "ashish@kortaben.se",
                "live_chat_url" => "none",
                "sender_name" => "ashish",
                "help_url" => "no help",
                "company_name" => "kb",
                "company_address" => "stockamollan"
            ]);

        Mail::to('hello@emiwebdb.kortaben.work')->send($mailable);
    }


    public function sendSuggestion(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'archive' => 'required',
            'record'  => 'required',
            'record_url' => 'required'

        ]);

        $userSuggestion = array_filter( $request->except('_token'));


        try {
            Mail::to('hello@emiwebdb.kortaben.work')->send(new SendSuggestion($userSuggestion) );

        } catch (Exception $e) {
            return $e->getMessage();
        }
       return redirect()->back()->with('success', "Your suggestion has been received");
    }
}
