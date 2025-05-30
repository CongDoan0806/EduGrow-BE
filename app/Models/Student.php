<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'class_name',
        'password',
        'created_at',
        'updated_at',
        'phone',
        'avatar'
    ];

    public function classGroup()
    {
        return $this->belongsTo(ClassGroup::class, 'class_id', 'class_id');
    }

    public function studentSubject()
    {
        return $this->hasMany(StudentSubject::class, 'student_id');
    }

    public function semesterGoal()
    {
        return $this->hasMany(SemesterGoal::class, 'student_id');
    }

    public function studyPlan()
    {
        return $this->hasMany(StudyPlan::class, 'student_id');
    }

    public function achievement()
    {
        return $this->hasMany(Achievement::class, 'student_id');
    }

    public function tag()
    {
        return $this->hasMany(Tag::class, 'student_id');
    }

    public function supportRequest()
    {
        return $this->hasMany(SupportRequest::class, 'student_id');
    }
}

