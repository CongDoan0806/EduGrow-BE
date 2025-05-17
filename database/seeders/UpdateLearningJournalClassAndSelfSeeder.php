<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UpdateLearningJournalClassAndSelfSeeder extends Seeder
{
     public function run(): void
    {
        DB::table('learning_journal_class')->where('id', 1)->update(['date' => '2025-04-01']);
        DB::table('learning_journal_class')->where('id', 2)->update(['date' => '2025-04-02']);
        DB::table('learning_journal_class')->where('id', 3)->update(['date' => '2025-04-02']);
        DB::table('learning_journal_class')->where('id', 4)->update(['date' => '2025-04-03']);
        DB::table('learning_journal_class')->where('id', 5)->update(['date' => '2025-04-04']);
        DB::table('learning_journal_class')->where('id', 6)->update(['date' => '2025-04-05']);
        DB::table('learning_journal_class')->where('id', 7)->update(['date' => '2025-04-05']);
        DB::table('learning_journal_class')->where('id', 8)->update(['date' => '2025-04-06']);
        DB::table('learning_journal_class')->where('id', 9)->update(['date' => '2025-04-06']);
        DB::table('learning_journal_class')->where('id', 10)->update(['date' => '2025-04-07']);

        
        DB::table('learning_journal_self')->where('id', 1)->update(['date' => '2025-04-01']);
        DB::table('learning_journal_self')->where('id', 2)->update(['date' => '2025-04-02']);
        DB::table('learning_journal_self')->where('id', 3)->update(['date' => '2025-04-03']);
        DB::table('learning_journal_self')->where('id', 4)->update(['date' => '2025-04-04']);
        DB::table('learning_journal_self')->where('id', 5)->update(['date' => '2025-04-04']);
        DB::table('learning_journal_self')->where('id', 6)->update(['date' => '2025-04-05']);
        DB::table('learning_journal_self')->where('id', 7)->update(['date' => '2025-04-05']);
        DB::table('learning_journal_self')->where('id', 8)->update(['date' => '2025-04-06']);
        DB::table('learning_journal_self')->where('id', 9)->update(['date' => '2025-04-06']);
        DB::table('learning_journal_self')->where('id', 10)->update(['date' => '2025-04-07']);
    }
}
