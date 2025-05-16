<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningJournal extends Model
{
    use HasFactory;

    protected $table = 'learning_journal';
    protected $primaryKey = 'learning_journal_id';
    public $timestamps = false;

    protected $fillable = ['id', 'semester', 'week_number', 'created_at'];

    public function studentSubject()
    {
        return $this->belongsTo(StudentSubject::class, 'id');
    }

    public function LearningJournalClass()
    {
        return $this->hasMany(LearningJournalClass::class, 'learning_journal_id');
    }

     public function LearningJournalSelf()
    {
        return $this->hasMany(LearningJournalSelf::class, 'learning_journal_id');
    }

    public function tag()
    {
        return $this->hasMany(Tag::class, 'learning_journal_id');
    }
    
}
