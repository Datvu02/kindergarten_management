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
        Schema::rename('password_reset_tokens', 'refresh_tokens');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('refresh_tokens', 'password_reset_tokens');
    }
};
