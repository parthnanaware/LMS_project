<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_child', function (Blueprint $table) {

            $table->id('order_child_id');

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('course_id');

            $table->integer('quantity')->default(1);

            // Prices
            $table->decimal('mrp', 10, 2);
            $table->decimal('sell_price', 10, 2);

            $table->timestamps();

            // ORDER FK
            $table->foreign('order_id')
                ->references('order_id')->on('order_master')
                ->onDelete('cascade');

            // COURSE FK
            $table->foreign('course_id')
                ->references('course_id')->on('tbl_corse')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_child');
    }
};
