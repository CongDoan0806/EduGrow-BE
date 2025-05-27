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
        Schema::table('semester_goal_contents', function (Blueprint $table) {
             $table->text('teacher_feedback')->nullable()->after('reflect');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('semester_goal_contents', function (Blueprint $table) {
             $table->dropColumn('teacher_feedback');
        });
    }
};
