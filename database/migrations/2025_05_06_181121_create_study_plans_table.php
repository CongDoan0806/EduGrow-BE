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
        Schema::dropIfExists('study_plans'); // <- thêm dòng này
        Schema::create('study_plans', function (Blueprint $table) {
            $table->id('plan_id');
            $table->unsignedBigInteger('student_id');
            $table->string('title');
            $table->string('day_of_week');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('color')->nullable()->default('#cfe9ff'); // thêm trường màu, nullable, có default màu xanh nhạt
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
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
        Schema::dropIfExists('study_plans');
    }
};
