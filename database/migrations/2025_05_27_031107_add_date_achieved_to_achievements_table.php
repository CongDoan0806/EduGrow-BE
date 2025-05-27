<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->date('date_achieved')->nullable();
        });
    }

    public function down()
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn('date_achieved');
        });
    }
};
