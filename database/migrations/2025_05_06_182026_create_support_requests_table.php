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
        Schema::dropIfExists('support_requests'); // <- thêm dòng này
        Schema::create('support_requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('admin_id');
            $table->text('message');
            $table->string('status');
            $table->dateTime('created_at')->useCurrent();

            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers')->onDelete('cascade');
            $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_requests');
    }
    
};
