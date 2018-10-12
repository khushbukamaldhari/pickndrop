<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserMeta;

class mailtrap extends Mailable
{
    use Queueable, SerializesModels;
    
    public $demo;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $demo )
    {
//        $user_meta_info 
        $this->demo = $demo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build( )
    {
        return $this->view('mail');
    }
}
