<?php

namespace App\Listeners;

use App\Events\UserRegistration;
use App\Mail\UserVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistration $event): void
    {
        Mail::to($event->email)->send(new UserVerifyEmail($event->email, $event->name, $event->otp));
    }
}
