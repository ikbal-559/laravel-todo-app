<?php

namespace App\Listeners;

use App\Events\TaskAssignedEvent;
use App\Jobs\TaskAssignJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskAssignNotification
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
     * @param  \App\Events\TaskAssigned  $event
     * @return void
     */
    public function handle(TaskAssignedEvent $event)
    {
        dispatch( new TaskAssignJob($event->user, $event->task ));

        //        Mail::to($this->user)->queue(new TaskEmail($this->user, $this->task)); Can ignore the JOB
    }
}
