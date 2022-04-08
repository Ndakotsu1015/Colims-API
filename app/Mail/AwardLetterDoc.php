<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AwardLetterDoc extends Mailable
{
    use Queueable, SerializesModels;

    public $details, $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $file)
    {
        $this->details = $details;
        $this->file = $file;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.awardletterdoc')
            ->attach($this->file, [
                'as' => 'awardletter.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
