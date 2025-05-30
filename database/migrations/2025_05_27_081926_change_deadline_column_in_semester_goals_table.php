<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    DB::statement('ALTER TABLE semester_goals MODIFY deadline DATETIME');
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    DB::statement('ALTER TABLE semester_goals MODIFY deadline DATE');
}
};
