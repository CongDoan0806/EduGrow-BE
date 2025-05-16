<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $primaryKey = 'subject_id';

     protected $fillable = ['subject_id', 'name', 'description', 'teacher_id', 'img'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function studentSubject()
    {
        return $this->hasMany(StudentSubject::class, 'subject_id');
    }

    public function semesterGoal()
    {
        return $this->hasMany(SemesterGoal::class, 'subject_id');
    }
}

