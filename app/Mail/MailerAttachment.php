<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailerAttachment extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**        
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        foreach($this->data['attachment'] as $file) {
            //attach the file
            $this->attach($file);
        }

        return $this
        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
        ->subject($this->data['subject'])
        ->view('mail/default')
        ->with('data', $this->data);
    }
}

?>