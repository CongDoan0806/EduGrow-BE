<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::table('learning_journal_class', function (Blueprint $table) {
            $table->date('date')->nullable()->after('learning_journal_id');
        });

        Schema::table('learning_journal_self', function (Blueprint $table) {
            $table->date('date')->nullable()->after('learning_journal_id');
        });
    }

    public function down(): void
    {
        Schema::table('learning_journal_class', function (Blueprint $table) {
            $table->dropColumn('date');
        });

        Schema::table('learning_journal_self', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
};
