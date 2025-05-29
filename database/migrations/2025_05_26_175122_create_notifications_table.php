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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'goal_created', 'goal_updated', 'student_tagged', 'teacher_replied'
            $table->text('message');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('teacher_id')->nullable(); 
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->unsignedBigInteger('goal_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->unsignedBigInteger('reply_id')->nullable(); 
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->enum('recipient_role',['student','teacher'])->nullable();
            
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
            $table->foreign('goal_id')->references('goal_id')->on('semester_goal_contents')->onDelete('cascade');
            $table->foreign('tag_id')->references('tag_id')->on('tags')->onDelete('cascade');
            $table->foreign('reply_id')->references('reply_id')->on('tag_replies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
