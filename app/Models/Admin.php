<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    public $timestamps = false;

    protected $fillable = ['name', 'email', 'password', 'created_at'];

    public function supportRequest()
    {
        return $this->hasMany(SupportRequest::class, 'admin_id');
    }
}

