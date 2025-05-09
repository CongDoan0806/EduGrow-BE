<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyPlan extends Model
{
    use HasFactory;

    protected $table = 'study_plans';
    protected $primaryKey = 'plan_id';
    public $timestamps = false;

    protected $fillable = ['student_id','title','day_of_week','start_time','end_time','created_at'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

