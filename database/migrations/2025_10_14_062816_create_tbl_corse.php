<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_corse', function (Blueprint $table) {
            $table->id();
            $table->string('course_title');
            $table->string('course_description'); 
            $table->string('course_image')->nullable(); //
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')
                    ->references('id')
                    ->on('tbl_subject')
                    ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_corse');
    }
};

