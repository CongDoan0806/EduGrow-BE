<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningJournalClass extends Model
{
    use HasFactory;

    protected $table = 'learning_journal_class';

        protected $fillable = [
        'learning_journal_id',
        'my_lesson',
        'self_assessment',
        'difficulties',
        'plan',
        'isSolved',
    ];
    public function learningJournal()
    {
        return $this->belongsTo(LearningJournal::class, 'learning_journal_id');
    }
}

