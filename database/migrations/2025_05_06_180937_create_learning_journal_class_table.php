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
        Schema::dropIfExists('learning_journal_class'); // <- thêm dòng này
        Schema::create('learning_journal_class', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_journal_id');
            $table->foreign('learning_journal_id')
                    ->references('learning_journal_id')
                    ->on('learning_journal')
                    ->onDelete('cascade');
            $table->string('my_lesson', 250);
            $table->string('self_assessment', 250);
            $table->string('difficulties', 250);
            $table->string('plan', 250);
            $table->boolean('isSolved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_journal_class');
    }
};
