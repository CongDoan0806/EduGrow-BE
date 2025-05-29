<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'message',
        'student_id',
        'teacher_id',
        'subject_id',
        'goal_id',
        'tag_id',
        'reply_id',
        'is_read',
        'recipient_role',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function goalContent()
    {
        return $this->belongsTo(SemesterGoalContent::class, 'goal_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function tagReply()
    {
        return $this->belongsTo(TagReplies::class, 'reply_id');
    }

    public function scopeGoalNotifications($query)
    {
        return $query->whereIn('type', ['goal_created', 'goal_updated']);
    }

    public function scopeTagNotifications($query)
    {
        return $query->whereIn('type', ['student_tagged', 'teacher_replied']);
    }

    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }
}