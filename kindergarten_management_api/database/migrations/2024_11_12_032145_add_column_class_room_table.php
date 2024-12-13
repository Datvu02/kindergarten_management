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
        Schema::table('classroom', function (Blueprint $table) {
            $table->unsignedBigInteger('homeroom_teacher_id')->nullable()->after('id');
            $table->foreign('homeroom_teacher_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classroom', function (Blueprint $table) {
            $table->dropColumn('homeroom_teacher_id');
        });
    }
};
