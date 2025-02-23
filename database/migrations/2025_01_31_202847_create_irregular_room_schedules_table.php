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
        Schema::create('irregular_room_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_schedule_id')
                ->references('id')
                ->on('room_schedules')
                ->cascadeOnDelete();

            $table->foreignId('student_info_id')
                ->references('id')
                ->on('student_infos')
                ->cascadeOnDelete();

            $table->string('days_recurring');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('irregular_room_schedules');
    }
};
