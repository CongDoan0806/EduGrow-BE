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
        Schema::create('semester_goal_contents', function (Blueprint $table) {
            $table->id('goal_id');
            $table->text('content');
            $table->string('reward')->nullable();
            $table->string('status')->default('pending');
            $table->text('reflect')->nullable();
            $table->unsignedBigInteger('sg_id');
            
            $table->foreign('sg_id')->references('sg_id')->on('semester_goals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semester_goal_contents');
    }
};