<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {

            $table->id('cart_id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');

            $table->integer('quantity')->default(1);

            $table->timestamps();

            $table->unique(['user_id', 'course_id']);

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

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
