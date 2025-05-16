<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('subject')->nullable();
        });
    }
    public function down()
    {
        Schema::table('teacher', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('avatar');
            $table->dropColumn('subject');

        });
    }
};
