<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleBadgeUnlocked
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
     *
     * @param  BadgeUnlocked  $event
     * @return void
     */
    public function handle(BadgeUnlocked $event)
    {
        // Retrieve the user and badge name from the event
        $user = $event->user;
        $badgeName = $event->badge_name;

        // Perform actions when a badge is unlocked
        // For example, update the user's profile with the new badge
       // $user->update(['badge' => $badgeName]);
    }
}
