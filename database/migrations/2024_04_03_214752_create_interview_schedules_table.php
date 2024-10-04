<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('interview_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->cascadeOnDelete();
            $table->dateTime('interview_datetime')->nullable();
            $table->integer('interview_type');
            $table->integer('status');
            $table->foreignId('interviewer_id')->nullable()->constrained('users', 'id');
            $table->timestamps();
        });
    }
    //interview status : 1 - scheduled , 2 - completed 3 - on hold
    //interview type : 1 - on site , 2 - online
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_schedules');
    }
};
