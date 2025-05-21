<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $primaryKey = 'tag_id';
    public $timestamps = false;

    protected $fillable = ['learning_journal_id', 'teacher_id', 'student_id', 'message', 'created_at'];

    public function learningJournal()
    {
        return $this->belongsTo(LearningJournal::class, 'learning_journal_id');
    }

    public function teachers()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // public function tagReplies()
    // {
    //     return $this->hasMany(TagReply::class, 'tag_id');
    // }
}
