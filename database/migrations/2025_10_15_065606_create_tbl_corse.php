<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_corse', function (Blueprint $table) {
            $table->id('course_id');
            $table->string('course_name');
            $table->json('subject_id')->nullable();
            $table->string('course_image')->nullable();
            $table->string('mrp');
            $table->string('sell_price');
            $table->text('course_description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_corse');
    }
};
