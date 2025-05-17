<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportRequest extends Model
{
    use HasFactory;

    protected $table = 'support_requests';
    protected $primaryKey = 'request_id';

    protected $fillable = ['student_id', 'teacher_id', 'admin_id', 'message', 'status', 'created_at'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
