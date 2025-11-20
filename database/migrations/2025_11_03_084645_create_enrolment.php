<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_enrolment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->decimal('mrp', 10, 2);
            $table->decimal('sell_price', 10, 2);
            $table->timestamps();

            // reference the actual users table (lowercase 'users')
            $table->foreign('student_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            // reference the actual courses table (fix name according to your DB)
            $table->foreign('course_id')
                  ->references('course_id')->on('tbl_corse') // or 'tbl_courses' if you rename table
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_enrolment');
    }
};
