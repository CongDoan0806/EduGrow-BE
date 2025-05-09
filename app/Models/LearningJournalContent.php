<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningJournalContent extends Model
{
    use HasFactory;

    protected $table = 'learning_journal_contents';  
    public $timestamps = false; 
    
    protected $fillable = ['learning_journal_id','isClass','isSelf','content','created_at'];

    public function learningJournal()
    {
        return $this->belongsTo(LearningJournal::class, 'learning_journal_id');
    }
}

