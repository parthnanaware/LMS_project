<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('session', function (Blueprint $table) {
            $table->string('video')->nullable()->change();
            $table->string('pdf')->nullable()->change();
            $table->string('task')->nullable()->change();
            $table->string('exam')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('session', function (Blueprint $table) {
            $table->string('video')->nullable(false)->change();
            $table->string('pdf')->nullable(false)->change();
            $table->string('task')->nullable(false)->change();
            $table->string('exam')->nullable(false)->change();
        });
    }
};
