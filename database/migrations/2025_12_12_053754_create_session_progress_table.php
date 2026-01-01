<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tbl_session_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('session_id');
            $table->string('video_file')->nullable();
            $table->string('pdf_file')->nullable();
            $table->string('task_file')->nullable();
            $table->string('exam_file')->nullable();
            $table->enum('video_status', ['locked','pending','approved'])->default('approved');
            $table->enum('pdf_status',   ['locked','pending','approved'])->default('locked');
            $table->enum('task_status',  ['locked','pending','approved'])->default('locked');
            $table->enum('exam_status',  ['locked','pending','approved'])->default('locked');
            $table->timestamps();
            $table->index(['user_id', 'session_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('tbl_session_progress');
    }
};
