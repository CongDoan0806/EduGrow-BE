<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';
    protected $primaryKey = 'teacher_id';
    public $timestamps = false;

    protected $fillable = ['name', 'email', 'password', 'created_at'];

    public function subject()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    public function tag()
    {
        return $this->hasMany(Tag::class, 'teacher_id');
    }

    public function supportRequest()
    {
        return $this->hasMany(SupportRequest::class, 'teacher_id');
    }
}

