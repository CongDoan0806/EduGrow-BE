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
        Schema::create('semester_goals', function (Blueprint $table) {
            $table->id('goal_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('subject_id');  
            $table->string('title');
            $table->string('semester');
            $table->text('description')->nullable();
            $table->string('status');
            $table->date('deadline');
            $table->dateTime('created_at')->useCurrent();
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semester_goals');
    }
};
