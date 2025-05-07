<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students'; 
    protected $primaryKey = 'student_id';
    public $timestamps = false; 

    protected $fillable = ['name', 'email', 'password', 'created_at'];

    public function classGroup()
    {
        return $this->hasOne(ClassGroup::class, 'student_id');
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