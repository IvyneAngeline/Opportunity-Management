<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPostMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $title,$description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title,$description)
    {
        $this->title=$title;
        $this->description=$description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $address = 'kejafix@gmail.com';
        $subject = 'New Post From Digital For Africa';
        $name = 'Digital 4 Africa';
        return $this->view('emails.post')
            ->from($address, $name)
            ->subject($subject)
            ->with([ 'title' =>
                $this->title ])->with([ 'description' =>
                $this->description ]);
    }
}
