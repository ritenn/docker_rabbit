<?php

namespace App\Listeners;

use App\Dictionary\EmailStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Queue\InteractsWithQueue;

class EmailNotification implements ShouldQueue
{
    /**
     * @param NotificationSent $event
     *
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        $event->notifiable->update(['status' => EmailStatus::SENT]);
    }
}
