<?php

namespace App\Listeners;

use App\Models\User;//add
use Illuminate\Http\Request;//add

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
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
    public function handle(Login $event): void
    {
        $user=user::find(auth()->user()->id);
        $user->access_ip = request()->ip();
        $user->save();
    }
}
