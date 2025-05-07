<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassGroup extends Model
{
    use HasFactory;

    protected $table = 'class_groups';
    protected $primaryKey = 'class_id';
    public $timestamps = false;

    protected $fillable = ['class_name', 'student_id', 'created_at'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
