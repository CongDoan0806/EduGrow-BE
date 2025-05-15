<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentSubject extends Model
{
    use HasFactory;

    protected $table = 'student_subject';

    protected $fillable = ['student_id', 'subject_id', 'joined_at', 'created_at'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function learningJournal()
    {
        return $this->hasMany(LearningJournal::class, 'id');
    }
}

