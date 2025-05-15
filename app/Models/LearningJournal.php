<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningJournal extends Model
{
    use HasFactory;

    protected $table = 'learning_journal';
    protected $primaryKey = 'learning_journal_id';

   protected $fillable = ['student_subject_id','semester', 'week_number', 'start_date', 'end_date'];

    public function studentSubject()
    {
        return $this->belongsTo(StudentSubject::class, 'student_subject_id');
    }

    public function tag()
    {
        return $this->hasMany(Tag::class, 'learning_journal_id');
    }

    public function learningJournalClass()
    {
        return $this->hasMany(LearningJournalClass::class, 'learning_journal_id');
    }

    public function learningJournalSelf()
    {
        return $this->hasMany(LearningJournalSelf::class, 'learning_journal_id');
    }
    
}
