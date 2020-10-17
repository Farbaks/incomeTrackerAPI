<?php

namespace App\Listeners;

use App\Events\ResetPassword;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendResetMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendResetPasswordMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ResetPassword  $event
     * @return void
     */
    public function handle(ResetPassword $event)
    {
        //
        Mail::to($event->user->email, $event->user->name)->send(new sendResetMail($event->user));
        
    }
}
