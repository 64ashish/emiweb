<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendSuggestion extends Mailable
{
    use Queueable, SerializesModels;

    public $userSuggestion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $userSuggestion)
    {
        //
        $this->userSuggestion = $userSuggestion;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Suggestion: Record number '.$this->userSuggestion['record'].' on Archive '. $this->userSuggestion['archive'],
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.suggestion',
            with: [
                'subject' =>  $this->userSuggestion['subject'] ,
                'email' =>  $this->userSuggestion['email'] ,
                'usermessage' =>  $this->userSuggestion['message'] ,
                'archive' =>  $this->userSuggestion['archive'] ,
                'record'  =>  $this->userSuggestion['record'] ,
                'record_url' =>$this->userSuggestion['record_url']
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
