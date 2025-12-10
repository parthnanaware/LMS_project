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

            // Which user placed this order
            $table->unsignedBigInteger('user_id');

            // Amounts
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);

            // Order status
            $table->enum('status', ['pending', 'paid', 'failed', 'cancelled'])
                  ->default('pending');

            // Payment info
            $table->string('payment_method')->nullable(); // UPI, Razorpay, COD, etc.
            $table->string('payment_id')->nullable();

            $table->timestamps();

            // FK → users(id)
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
