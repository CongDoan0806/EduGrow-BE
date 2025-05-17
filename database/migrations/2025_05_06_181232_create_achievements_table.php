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
        Schema::dropIfExists('achievements'); // <- thêm dòng này
        Schema::create('achievements', function (Blueprint $table) {
            $table->id('achievement_id');
            $table->unsignedBigInteger('student_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->dateTime('uploaded_at')->useCurrent();
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievements');
    }
};
