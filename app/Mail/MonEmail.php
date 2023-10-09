<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class MonEmail extends Mailable
{
    use Queueable,SerializesModels;
    protected $name;
    protected $email;
    protected $message;
    public $subject;

    public function __construct($name, $email, $subject, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
        $this->subject = $subject;
    }
    public function build()
    {
        return $this->subject($this->subject)
                    ->from($this->email,$this->name)
                    ->html(view('emails.mon_email',[
                        'customMessage' => $this->message,
                        'email' => $this->email,
                    ])->render());
    }
}
