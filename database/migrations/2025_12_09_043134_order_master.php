<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_master', function (Blueprint $table) {

            $table->id('order_id');

            $table->unsignedBigInteger('user_id');

            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);

            $table->enum('status', ['pending', 'paid', 'failed', 'cancelled'])
                  ->default('pending');

            $table->string('payment_method')->nullable(); // UPI, Razorpay, COD, etc.
            $table->string('payment_id')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_master');
    }
};
