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
        Schema::create('learning_journal_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_journal_id');
            $table->boolean('isClass')->default(false);
            $table->boolean('isSelf')->default(false);  
            $table->text('content');
            $table->foreign('learning_journal_id')->references('learning_journal_id')->on('learning_journal')->onDelete('cascade');
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_journal_contents');
    }
};
