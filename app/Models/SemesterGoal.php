<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SemesterGoal extends Model
{
    use HasFactory;

    protected $table = 'semester_goals';
    protected $primaryKey = 'goal_id';

    protected $fillable = ['student_id', 'subject', 'title', 'semester', 'description', 'status', 'deadline', 'created_at'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
