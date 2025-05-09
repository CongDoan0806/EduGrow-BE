<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'teachers';
    protected $primaryKey = 'teacher_id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
    ];

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

