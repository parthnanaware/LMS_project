<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {

            // Primary key
            $table->id('cart_id');

            // Foreign keys
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');

            // Quantity
            $table->integer('quantity')->default(1);

            $table->timestamps();

            // Same user cannot add same course twice
            $table->unique(['user_id', 'course_id']);

            // USER foreign key
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // COURSE foreign key
            $table->foreign('course_id')
                  ->references('course_id')
                  ->on('tbl_corse')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
