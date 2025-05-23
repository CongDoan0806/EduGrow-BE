<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Thêm class_id vào bảng students
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->nullable()->after('password');
            $table->foreign('class_id')->references('class_id')->on('class_groups')->onDelete('set null');
        });

        // Xóa student_id khỏi bảng class_groups
        Schema::table('class_groups', function (Blueprint $table) {
            if (Schema::hasColumn('class_groups', 'student_id')) {
                $table->dropForeign(['student_id']); // nếu có ràng buộc khóa ngoại
                $table->dropColumn('student_id');
            }
        });
    }

    public function down()
    {
        // Khôi phục student_id vào bảng class_groups
        Schema::table('class_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable()->after('id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
        });

        // Xóa class_id khỏi bảng students
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
        });
    }
};
