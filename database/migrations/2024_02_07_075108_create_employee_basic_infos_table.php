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
        Schema::create('employee_basic_infos', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_birth')->nullable();
            $table->string('cnic', 15)->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('address')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('profile_image')->nullable();
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_basic_infos');
    }
};
