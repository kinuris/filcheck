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
        Schema::create('student_infos', function (Blueprint $table) {
            $table->id();

            $table->string('rfid')->unique();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('student_number');
            $table->string('phone_number');

            $table->enum('gender', ['Male', 'Female']);

            $table->string('guardian');
            $table->string('address');
            $table->date('birthdate');
            $table->string('profile_picture');

            $table->foreignId('department_id')
                ->references('id')
                ->on('departments');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_infos');
    }
};
