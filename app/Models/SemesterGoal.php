<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterGoal extends Model
{
    use HasFactory;

    protected $table = 'semester_goals';
    protected $primaryKey = 'sg_id';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'subject_id',
        'semester',
        'deadline',
        'created_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function contents()
    {
        return $this->hasMany(SemesterGoalContent::class, 'sg_id');
    }
}