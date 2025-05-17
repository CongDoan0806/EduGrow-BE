<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LearningJournalClassSeeder extends Seeder
{
    public function run()
    {
        DB::table('learning_journal_class')->insert([
    [
        'learning_journal_id' => 1,
        'my_lesson' => 'Reviewed technical vocabulary in IT English',
        'self_assessment' => 'Understood most terms but need more practice',
        'difficulties' => 'Struggled with pronunciation of some words',
        'plan' => 'Practice using new vocabulary in context',
        'isSolved' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'learning_journal_id' => 2,
        'my_lesson' => 'Completed TOEIC listening section mock test',
        'self_assessment' => 'Performance was average; better than last week',
        'difficulties' => 'Fast speech in audio clips',
        'plan' => 'Listen to TOEIC podcasts daily',
        'isSolved' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'learning_journal_id' => 3,
        'my_lesson' => 'Practiced speaking fluently about daily activities',
        'self_assessment' => 'Improved fluency but grammar needs work',
        'difficulties' => 'Using correct tenses in conversation',
        'plan' => 'Join speaking clubs and review grammar',
        'isSolved' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'learning_journal_id' => 4,
        'my_lesson' => 'Learned phrasal verbs and applied them in writing',
        'self_assessment' => 'Can recognize but hard to use naturally',
        'difficulties' => 'Mixing up similar phrasal verbs',
        'plan' => 'Make flashcards and use in sentences',
        'isSolved' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'learning_journal_id' => 5,
        'my_lesson' => 'Group discussion on professional communication',
        'self_assessment' => 'Participated confidently, improved intonation',
        'difficulties' => 'Sometimes too fast when speaking',
        'plan' => 'Record and listen to myself to adjust speed',
        'isSolved' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    // Tuần 2
    [
        'learning_journal_id' => 6,
        'my_lesson' => 'Explored IT-related case studies in English',
        'self_assessment' => 'Could understand but struggled to explain back',
        'difficulties' => 'Finding correct vocabulary under pressure',
        'plan' => 'Review notes and rehearse summaries',
        'isSolved' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'learning_journal_id' => 7,
        'my_lesson' => 'Worked on TOEIC reading comprehension',
        'self_assessment' => 'Got 80% accuracy in practice test',
        'difficulties' => 'Time management during test',
        'plan' => 'Use a timer during practice',
        'isSolved' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'learning_journal_id' => 8,
        'my_lesson' => 'Delivered short presentations on daily routine',
        'self_assessment' => 'Clear pronunciation and confident tone',
        'difficulties' => 'Occasional filler words and hesitation',
        'plan' => 'Practice with peer feedback',
        'isSolved' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'learning_journal_id' => 9,
        'my_lesson' => 'Discussed English idioms in class',
        'self_assessment' => 'Can recall meanings but need usage practice',
        'difficulties' => 'Misusing idioms in wrong contexts',
        'plan' => 'Write diary using 5 idioms a day',
        'isSolved' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'learning_journal_id' => 10,
        'my_lesson' => 'Engaged in TOEIC speaking simulations',
        'self_assessment' => 'Improved clarity and reduced nervousness',
        'difficulties' => 'Lack of topic-specific vocabulary',
        'plan' => 'Build vocabulary lists per topic',
        'isSolved' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);

    }
}

