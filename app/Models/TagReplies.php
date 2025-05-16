<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagReplies extends Model
{
    use HasFactory;
    protected $table = 'tag_replies';
    protected $primaryKey = 'reply_id';
    protected $fillable = [
        'tag_id',
        'sender_type',
        'sender_id',
        'content',
    ];
}
