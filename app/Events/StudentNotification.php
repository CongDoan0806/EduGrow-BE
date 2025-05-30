<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentNotification
{
    use InteractsWithSockets, SerializesModels;

    public $notification;
    public $student;

    public function __construct($student, $notification)
    {
        $this->student = $student;
        $this->notification = $notification;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('student.' . $this->student->id);
    }

    public function broadcastAs()
    {
        return 'StudentNotification';
    }
}
