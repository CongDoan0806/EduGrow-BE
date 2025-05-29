<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achievement extends Model
{
    use HasFactory;

    protected $table = 'achievements';
    protected $primaryKey = 'achievement_id';
    public $timestamps = false;

    protected $fillable = ['student_id','title','description','file_path', 'date_achieved','uploaded_at'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

