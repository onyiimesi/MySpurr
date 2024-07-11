<?php

namespace App\Actions;

use Illuminate\Support\Facades\Mail;

class SendMailAction
{
    protected $email;
    protected $action;

    public function __construct($email, $action)
    {
        $this->email = $email;
        $this->action = $action;
    }

    public function run()
    {
        Mail::to($this->email)->send($this->action);
    }
}


