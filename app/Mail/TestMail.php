<?php

namespace App\Mail;

use CraigPaul\Mail\TemplatedMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        return $this->view('emails.test');

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
    }
}
