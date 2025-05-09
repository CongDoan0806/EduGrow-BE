<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
    ];
    public function supportRequest()
    {
        return $this->hasMany(SupportRequest::class, 'admin_id');
    }
}

