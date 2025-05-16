<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterGoalContent extends Model
{
    use HasFactory;

    protected $table = 'semester_goal_contents';
    protected $primaryKey = 'goal_id';
    public $timestamps = false;

    protected $fillable = [
        'content',
        'reward',
        'status',
        'reflect',
        'sg_id'
    ];

    public function semesterGoal()
    {
        return $this->belongsTo(SemesterGoal::class, 'sg_id');
    }
}