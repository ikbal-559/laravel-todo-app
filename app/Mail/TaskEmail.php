<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $task;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $task )
    {
        $this->user = $user;
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreplay@example.com', 'Example')
            ->subject('New Task Assigned.')
            ->markdown('emails.tasks.new', [
            'user' => $this->user,
            'task' => $this->task,
        ]);
    }
}
