<?php

namespace App\Listeners;

use App\Constants\Status;
use App\Events\UserActivityEvent;
use App\Models\ActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserActivityListener
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
    public function handle(UserActivityEvent $event)
    {

        // Log the user activity
        ActivityLog::create([
            'author_id' => $event->user->id,
            'role_id' => $event->user->role,
            'email' => $event->user->email,
            'name' => $event->user->name,
            'ip_address' => request()->ip(),
            'activity' => $event->activity,
            'action' => $event->action,
            'status'     => Status::ACTIVE,
        ]);
    }
}
