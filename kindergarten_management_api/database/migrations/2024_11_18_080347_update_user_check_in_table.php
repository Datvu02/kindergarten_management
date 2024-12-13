<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_check_in', function (Blueprint $table) {
            $table->boolean('check_in_today')->default(false);
            $table->boolean('check_in_yesterday')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_check_in', function (Blueprint $table) {
            $table->dropColumn('check_in_today', 'check_in_yesterday');
            $table->dropTimestamps();
        });
    }
};
