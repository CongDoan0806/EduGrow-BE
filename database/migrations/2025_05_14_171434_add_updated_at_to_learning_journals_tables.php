<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Thêm cột updated_at vào bảng learning_journals
        Schema::table('learning_journal', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });

        // Thêm cột updated_at vào bảng learning_journal_classes

        // Thêm cột updated_at vào bảng learning_journal_self

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Xóa cột updated_at khỏi bảng learning_journals
        Schema::table('learning_journal', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });

        // Xóa cột updated_at khỏi bảng learning_journal_classes

    }
};
