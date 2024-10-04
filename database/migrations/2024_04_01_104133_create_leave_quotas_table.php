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
        Schema::create('leave_quotas', function (Blueprint $table) {
            $table->id();
            $table->integer('sick_leave')->nullable();
            $table->integer('casual_leave')->nullable();
            $table->integer('annual_leave')->nullable();
            $table->integer('unpaid_leave')->nullable();
            $table->foreignId('user_id')->constrained('users' , 'id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_quotas');
    }
};
