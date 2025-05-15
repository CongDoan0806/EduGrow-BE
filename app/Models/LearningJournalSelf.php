<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningJournalSelf extends Model
{
    use HasFactory;
    protected $table = 'learning_journal_self';

    protected $fillable = [
        'learning_journal_id',
        'date',
        'my_lesson',
        'time_allocation',
        'learning_resources',
        'learning_activities',
        'isConcentration',
        'isFollowPlan',
        'evaluation',
        'reinforcing',
        'note',
    ];
    public function learningJournal()
    {
        return $this->belongsTo(LearningJournal::class, 'learning_journal_id');
    }
}