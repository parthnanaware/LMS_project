<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('session', function (Blueprint $table) {
            if (!Schema::hasColumn('session', 'section_id')) {
                $table->unsignedBigInteger('section_id')->nullable()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('session', function (Blueprint $table) {
            if (Schema::hasColumn('session', 'section_id')) {
                $table->dropColumn('section_id');
            }
        });
    }
};
