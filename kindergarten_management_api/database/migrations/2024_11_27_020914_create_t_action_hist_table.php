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
        Schema::create('t_action_hist', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('operation_type')->comment('1: Login, 2: Logout, 3: Session Timeout');
            $table->timestamp('operation_dt');
            $table->string('user_id');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_action_hist');
    }
};
