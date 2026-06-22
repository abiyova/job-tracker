<?php

namespace App\Listeners;

//use App\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use App\Models\LoginLog;

class LogLogout
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
    public function handle(Logout $event): void
    {
        LoginLog::where('user_id', $event->user->id)
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first()?->update(['logout_at' => now()]);
    }
}
