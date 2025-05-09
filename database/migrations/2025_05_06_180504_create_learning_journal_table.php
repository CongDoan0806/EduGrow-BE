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
        Schema::create('learning_journal', function (Blueprint $table) {
            $table->id('learning_journal_id');
            $table->unsignedBigInteger('id');
            $table->string('semester');
            $table->integer('week_number');
            $table->dateTime('created_at')->useCurrent();
            $table->foreign('id')->references('id')->on('student_subject')->onDelete('cascade');
        });
    }

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
