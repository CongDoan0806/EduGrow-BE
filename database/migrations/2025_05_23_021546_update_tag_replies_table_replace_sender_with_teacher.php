<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::table('tag_replies', function (Blueprint $table) {
            // Xóa 2 cột sender_id và sender_type nếu tồn tại
            if (Schema::hasColumn('tag_replies', 'sender_id')) {
                $table->dropColumn('sender_id');
            }
            if (Schema::hasColumn('tag_replies', 'sender_type')) {
                $table->dropColumn('sender_type');
            }

            // Thêm cột teacher_id (liên kết với bảng teachers)
            $table->unsignedBigInteger('teacher_id')->after('tag_id');

            // Khóa ngoại
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('tag_replies', function (Blueprint $table) {
            // Xóa ràng buộc và cột teacher_id
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');

            // Thêm lại 2 cột sender_id và sender_type
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->string('sender_type')->nullable();
        });
    }
};
