<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('learning_journal_self', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_journal_id');
            $table->string('my_lesson', 250);
            $table->string('time_allocation', 30);
            $table->string('learning_resources', 250);
            $table->string('learning_activities', 250);
            $table->boolean('isConcentration')->default(false);
            $table->boolean('isFollowPlan')->default(false);
            $table->string('evaluation', 250);
            $table->string('reinforcing', 250);
            $table->string('note', 250);
            $table->timestamps();
            $table->foreign('learning_journal_id')
                    ->references('learning_journal_id')
                    ->on('learning_journal')
                    ->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('learning_journal_self');
    }
};
