<?php
namespace App\Events;

use App\Models\Tag;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class TeacherTagged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function broadcastOn()
    {
        return new Channel('teacher.' . $this->tag->teacher_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->tag->id,
            'content' => $this->tag->content,
            'student_id' => $this->tag->student_id,
            'student_name' => $this->tag->student ? $this->tag->student->name : 'Unknown',
            'created_at' => $this->tag->created_at->toDateTimeString(),
        ];
    }
}