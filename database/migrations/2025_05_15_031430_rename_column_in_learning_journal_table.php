<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::table('learning_journal', function (Blueprint $table) {
            $table->renameColumn('id', 'student_subject_id');
        });
    }

    public function down()
    {
        Schema::table('learning_journal', function (Blueprint $table) {
            $table->renameColumn('student_subject_id', 'id');
        });
    }
};
