<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('learning_journal'); // <- thêm dòng này
        Schema::create('learning_journal', function (Blueprint $table) {
            $table->id('learning_journal_id');
            $table->unsignedBigInteger('student_subject_id');
            $table->string('semester');
            $table->integer('week_number');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->foreign('student_subject_id')->references('id')->on('student_subject')->onDelete('cascade');
        });
    }
// Schema::dropIfExists('learning_journal_logs'); 
// Schema::create('learning_journal_logs', function (Blueprint $table) {
//     $table->id('learning_journal_log_id');
//     $table->unsignedBigInteger('learning_journal_id');
//     $table->string('action');
//     $table->dateTime('created_at')->useCurrent();
//     $table->foreign('learning_journal_id')->references('learning_journal_id')->on('learning_journal')->onDelete('cascade');
// });
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_journal');
    }
};
