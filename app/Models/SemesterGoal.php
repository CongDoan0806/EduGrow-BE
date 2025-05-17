<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterGoal extends Model
{
    use HasFactory;

    protected $table = 'semester_goals';
<<<<<<< HEAD
    protected $primaryKey = 'sg_id';
    public $timestamps = false;
=======
    protected $primaryKey = 'goal_id';
>>>>>>> 5e7d3bbf6ea7947c6c20c778083b1627fa945e20

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