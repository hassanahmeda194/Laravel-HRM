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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('leave_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->integer('status')->default(2);
            $table->timestamps();
        });
    }
    //ststus = 0 reject , 1 approved ,2 pending
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
